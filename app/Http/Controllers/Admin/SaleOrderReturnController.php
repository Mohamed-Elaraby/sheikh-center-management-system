<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SaleOrderReturnDatatable;
use App\Models\Bank;
use App\Models\Client;
use App\Models\ClientTransaction;
use App\Models\MoneySafe;
use App\Models\Product;
use App\Models\SaleOrder;
use App\Models\SaleOrderProducts;
use App\Models\SaleOrderReturn;
use App\Models\SaleOrderReturnProducts;
use App\Traits\HelperTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class SaleOrderReturnController extends Controller
{
    use HelperTrait;

    public function index(SaleOrderReturnDatatable $orderReturnDatatable)
    {
        return $orderReturnDatatable -> render('admin.saleOrderReturns.index');
    }

    public function create()
    {
        $sale_order_id = request('sale_order_id');
        $saleOrder = SaleOrder::findOrFail($sale_order_id);
        $saleOrderProducts = SaleOrderProducts::where('sale_order_id', $sale_order_id)->get();
        $orderReturn_ids = collect($saleOrder->saleOrderReturns) -> pluck('id')-> toArray();
        $saleOrderReturnProducts = SaleOrderReturnProducts::whereIn('sale_order_return_id', $orderReturn_ids)->get();

        // new products
        $new_quantity_with_code = [];

        foreach ($saleOrderReturnProducts as $new_product)
        {
            $code = $new_product['item_code'];
            $quantity = $new_product['item_quantity'];
            $new_quantity_with_code[$code] = isset($new_quantity_with_code[$code]) ? $new_quantity_with_code[$code] + $quantity : $quantity;

        } // end foreach

        $new_quantity_with_code = Arr::dot($new_quantity_with_code);

        foreach ($new_quantity_with_code as $code => $quantity) {
            $collection = $saleOrderProducts -> map(function ($value)use($code, $quantity){
                if ($value -> item_code == $code) {
                    return $value -> item_quantity = $value -> item_quantity - $quantity;
                }
            });
        }

        return view('admin.saleOrderReturns.create', compact('saleOrder', 'saleOrderProducts', 'saleOrderReturnProducts'));
    }

    public function store(Request $request)
    {
        $amount_paid = [];
        $amount_paid_bank = [];
        $amount_paid_add_to_client_balance = [];
//        dd($request->all());
        $sale_order_id = $request -> sale_order_id;
        $branch_id = $request -> branch_id;
        $user_id = Auth::user()->id;
        $invoice_number = SaleOrderReturn::all()->last() ? SaleOrderReturn::all()->last()->id + 1 : 1;
        $invoice_date = Carbon::now()->toDateString();
        $sale_order_return_data = $request->except('product_data');
        $sale_order_return_products = $request -> product_data;
        $client_id = SaleOrder::findOrFail($request -> sale_order_id) -> check -> client_id;
        $client = Client::findOrFail($client_id);
        $data_init =
            [
                'user_id' => $user_id,
                'invoice_number' => $invoice_number,
                'invoice_date' => $invoice_date,
            ];
//        dd($sale_order_return_data);
        $sale_order_return = SaleOrderReturn::create($sale_order_return_data + $data_init);
        $sale_order_return_id = $sale_order_return -> id;

        foreach ($sale_order_return_products as $product) {
            if (isset($product ['checked'])) {

                $sale_order_return -> saleOrderReturnProducts() -> create($product);

                $item_code = $product ['item_code'];
                $item_quantity = $product ['item_quantity'];
                $item_sub_total = $product ['item_sub_total'];
                $return_amount_in = $product ['return_amount_in'];

                // return quantity in products table
                $item_exist_in_products_table = Product::where(['branch_id' => $branch_id, 'code' => $item_code])->first();
                if ($item_exist_in_products_table) {
                    $item_exist_in_products_table -> update([
                        'quantity' => $item_exist_in_products_table -> quantity + $item_quantity
                    ]);
                }

                if ($return_amount_in == 'money_safe') {
                    /* Update Money Safe Amount */
                    $last_amount_money_safe = MoneySafe::where('branch_id', $request -> branch_id)->get()->last();
                    $final_amount_money_safe = $last_amount_money_safe ? $last_amount_money_safe->final_amount : 0;
                    $sale_order_return->moneySafes()->create([
                        'amount_paid' => $item_sub_total,
                        'final_amount' => ($final_amount_money_safe - ($item_sub_total)),
                        'user_id' => Auth::user()->id,
                        'branch_id' => $request -> branch_id,
                    ]);
                    array_push($amount_paid, $item_sub_total);
                }elseif ($return_amount_in == 'bank') {
                    /* Update Bank Amount */
                    $last_amount_bank = Bank::where('branch_id', $request -> branch_id)->get()->last();
                    $final_amount_bank = $last_amount_bank ? $last_amount_bank->final_amount : 0;
                    $sale_order_return ->banks()->create([
                        'amount_paid' => $item_sub_total,
                        'final_amount' => ($final_amount_bank - ($item_sub_total)),
                        'money_process_type' => 0,
                        'user_id' => Auth::user()->id,
                        'branch_id' => $request -> branch_id,
                    ]);
                    array_push($amount_paid_bank, $item_sub_total);
                }elseif ($return_amount_in == 'client_balance') {
                    /* Update client balance */
//                    $client = Client::whereHas('saleOrders', function ($query)use ($sale_order_id){
//                        $query -> where('id', $sale_order_id);
//                    })->first();
//                    if ($client)
//                    {
//                        $client -> update(
//                            [
//                                'balance' => $client->balance + $item_sub_total
//                            ]
//                        );
//                    }
                    array_push($amount_paid_add_to_client_balance, $item_sub_total);
                }
            }
        }
//        dd($amount_paid, $amount_paid_bank);
        /* Record Transaction On Client Transaction Table */
        $amount_paid = array_sum($amount_paid);
        $amount_paid_bank = array_sum($amount_paid_bank) ?? 0;
        $amount_paid_add_to_client_balance = array_sum($amount_paid_add_to_client_balance);
        $total_amounts = $amount_paid + $amount_paid_bank + $amount_paid_add_to_client_balance;
        $total_amount_paid_plus_bank = $amount_paid + $amount_paid_bank;

        /* Update Supplier balance after subtract total amounts */
        $client_balance_after_add_total_amounts_paid = $client->balance + $total_amounts ;
        $client->update(['balance' => $client_balance_after_add_total_amounts_paid ]);

        $this -> insertToClientTransaction($sale_order_return,
            [
                'total_amount'                          => $total_amounts,
                'client_balance'                        => $client_balance_after_add_total_amounts_paid,
                'details'                               => 'فاتورة مردودات مبيعات رقم / ' . $sale_order_return -> invoice_number,
                'amount_paid'                           => $amount_paid,
                'amount_paid_bank'                      => $amount_paid_bank,
                'amount_paid_add_to_client_balance'     => $amount_paid_add_to_client_balance,
                'transaction_date'                      => $invoice_date,
                'transaction_type'                      => 'debit',
                'debit'                                 => $total_amounts,
                'user_id'                               => $user_id,
                'client_id'                             => $client_id
            ]
        );

        if ($total_amount_paid_plus_bank > 0 )
        {
            /* Update Supplier balance after add total amounts paid plus bank*/
            $client_balance_after_subtract_total_amount_paid_plus_bank = $client->balance - $total_amount_paid_plus_bank ;
            $client->update(['balance' => $client_balance_after_subtract_total_amount_paid_plus_bank ]);

            ClientTransaction::create([
                'total_amount'                          => $total_amount_paid_plus_bank,
                'client_balance'                        => $client_balance_after_subtract_total_amount_paid_plus_bank,
                'details'                               => 'تحصيل نقدى من قيمة فاتورة مردودات مبيعات رقم / ' . $sale_order_return -> invoice_number,
                'amount_paid'                           => $amount_paid,
                'amount_paid_bank'                      => $amount_paid_bank,
                'transaction_date'                      => $invoice_date,
                'transaction_type'                      => 'credit',
                'credit'                                => $total_amount_paid_plus_bank,
                'user_id'                               => $user_id,
                'client_id'                             => $client_id,
            ]);
        }
        return redirect() -> route('admin.saleOrderReturns.show', $sale_order_return_id);
    }

    public function show($id)
    {
        $sale_order_returns = SaleOrderReturn::findOrFail($id);
        return view('admin.saleOrderReturns.show_invoice', compact('sale_order_returns'));
    }

    public function saleOrderReturnProducts($sale_order_return_id)
    {
        // show sale orders products Page
        $saleOrderReturns = SaleOrderReturn::findOrFail($sale_order_return_id); // show products for sale order
        return view('admin.saleOrderReturns.orderProducts', compact('saleOrderReturns'));
    }
}

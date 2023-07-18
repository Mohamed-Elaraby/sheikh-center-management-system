<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\PriceListDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaleOrder\AddSaleOrderRequest;
use App\Http\Requests\SaleOrder\EditOpenSaleOrder;
use App\Models\Branch;
use App\Models\PriceList;
use Auth;
use Illuminate\Http\Request;
use PDF;

class PriceListController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read-priceList')->only('index');
        $this->middleware('permission:create-priceList')->only('create');
        $this->middleware('permission:update-priceList')->only('edit');
        $this->middleware('permission:delete-priceList')->only('destroy');
    }

    public function index(PriceListDatatable $priceListDatatable)
    {
        return $priceListDatatable -> render('admin.priceList.index');
    }

    public function create()
    {
        $check_id = request('check_id');
//        $client_id = Check::findOrFail($check_id) -> car -> client_id;
        $branches = Branch::pluck('display_name', 'id')->toArray();
//        $categories = Category::all();
        return view('admin.priceList.create', compact('branches'));
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $user_id = Auth::user()->id;
        $order_products = $request->product_data;
//        dd($order_products);
        $priceList = PriceList::create($request->except('product_data') + ['user_id' => $user_id]);
        foreach ($order_products as $product)
        {
            $priceList -> priceListProducts() -> create($product);
        }

        return redirect() -> route('admin.priceList.show', $priceList -> id) -> with('success', __('trans.price list added successfully'));
    }

    public function edit($id)
    {
        $priceList = PriceList::findOrFail($id);
        $branches = Branch::pluck('display_name', 'id')->toArray();
        return view('admin.priceList.edit', compact('branches', 'priceList'));
    }

    public function update(Request $request, $id)
    {
//        dd($id);
        $priceList = PriceList::findOrFail($id);
        $priceList -> update($request->except(['product_data']));
        $product_data = $request -> product_data;
        $priceList -> priceListProducts() -> delete();
        foreach ($product_data as $product)
        {
            $priceList -> priceListProducts() -> create($product);
        }
        return redirect() -> back();
    }

    public function show($id)
    {
        $price_list= PriceList::findOrFail($id);
        return view('admin.priceList.show_price_list', compact('price_list'));
    }

    public function destroy($id)
    {
        $priceList = PriceList::findOrFail($id);
        $priceList -> priceListProducts () -> delete();
        $priceList ->delete();
        return redirect() -> back() ->with('error', __('trans.open sale order delete successfully'));
    }

    public function priceListProducts($price_list_id)
    {
        // show sale orders products Page
        $priceList = PriceList::findOrFail($price_list_id); // show products for price List
        return view('admin.priceList.priceListProducts', compact('priceList'));
    }

    public function download_price_list(Request $request)
    {
        $priceListId = $request -> price_list_id;
//        $data = [];
        $data['price_list'] = PriceList::findOrFail($priceListId);
        $mpdf = PDF::loadView('admin.priceList.download_price_list', $data, [], [
            'margin_top' => 80,
            'margin_header' => 10,
            'margin_footer' => 20,

        ]);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoArabic = true;
        $mpdf->autoLangToFont = true;
        $mpdf->showImageErrors = true;
        $mpdf->setAutoBottomMargin = true;
//         $mpdf->download($data['price_list']->chassis_number.'.pdf');
        if ($request->download)
        {
            return $mpdf->download($data['price_list']->chassis_number.'.pdf');

        }
        return $mpdf->stream($data['price_list']->chassis_number.'.pdf');
    }


    public function download_work_order(Request $request)
    {
        $priceListId = $request -> price_list_id;
//        $data = [];
        $data['price_list'] = PriceList::findOrFail($priceListId);
        $mpdf = PDF::loadView('admin.priceList.download_work_order', $data, [], [
            'margin_top' => 80,
            'margin_header' => 10,
            'margin_footer' => 20,

        ]);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoArabic = true;
        $mpdf->autoLangToFont = true;
        $mpdf->showImageErrors = true;
        $mpdf->setAutoBottomMargin = true;
//         $mpdf->download($data['price_list']->chassis_number.'.pdf');
        if ($request->download)
        {
            return $mpdf->download('work order - '.$data['price_list']->chassis_number.'.pdf');

        }
        return $mpdf->stream('work order - '.$data['price_list']->chassis_number.'.pdf');
    }

}

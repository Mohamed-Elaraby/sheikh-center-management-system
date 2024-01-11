<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\MoneySafeOpeneingBalance;
use App\Models\Statement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class StatementController extends Controller
{

    public function get_tables_of_statement(Request $request)
    {

//        dd($request -> all());
        if ($request -> ajax())
        {
            $start_date = $request -> startDate;
            $end_date = $request -> endDate;
            $branch_id = $request -> branchId;
            $date_range = [$start_date.' 00:00:00', $end_date.' 23:59:59'];
//            dd($date_range, $branch_id);
//            $branch_id = auth()->user()->branch_id ?? \request('branch_id');
//            $date = $date_range;

            if (!empty($start_date) && !empty($end_date) && !empty($branch_id)){
                $statements = Statement::where('branch_id', $branch_id) -> whereBetween('updated_at', $date_range)->get();
                $total_imports_cash = Statement::where('branch_id', $branch_id) -> whereBetween('updated_at', $date_range)->sum('imports_cash');
                $total_imports_network = Statement::where('branch_id', $branch_id) -> whereBetween('updated_at', $date_range)->sum('imports_network');
                $total_imports_bank_transfer = Statement::where('branch_id', $branch_id) -> whereBetween('updated_at', $date_range)->sum('imports_bank_transfer');
                $total_card_details_hand_labour = Statement::where('branch_id', $branch_id) -> whereBetween('updated_at', $date_range)->sum('card_details_hand_labour');
                $total_card_details_new_parts = Statement::where('branch_id', $branch_id) -> whereBetween('updated_at', $date_range)->sum('card_details_new_parts');
                $total_card_details_used_parts = Statement::where('branch_id', $branch_id) -> whereBetween('updated_at', $date_range)->sum('card_details_used_parts');
                $total_card_details_tax = Statement::where('branch_id', $branch_id) -> whereBetween('updated_at', $date_range)->sum('card_details_tax');
                $total_expenses_cash = Statement::where('branch_id', $branch_id) -> whereBetween('updated_at', $date_range)->sum('expenses_cash');
                $total_expenses_network = Statement::where('branch_id', $branch_id) -> whereBetween('updated_at', $date_range)->sum('expenses_network');
                $total_custody_administration_cash = Statement::where('branch_id', $branch_id) -> whereBetween('updated_at', $date_range)->sum('custody_administration_cash');
                $total_custody_administration_network = Statement::where('branch_id', $branch_id) -> whereBetween('updated_at', $date_range)->sum('custody_administration_network');
                $total_cash_to_administration = Statement::where('branch_id', $branch_id) -> whereBetween('updated_at', $date_range)->sum('cash_to_administration');
                $total_advances_and_salaries_cash = Statement::where('branch_id', $branch_id) -> whereBetween('updated_at', $date_range)->sum('advances_and_salaries_cash');
                $total_advances_and_salaries_network = Statement::where('branch_id', $branch_id) -> whereBetween('updated_at', $date_range)->sum('advances_and_salaries_network');
                $total_imports = $total_imports_cash + $total_imports_network + $total_imports_bank_transfer ;
                $total_card_details = $total_card_details_hand_labour + $total_card_details_new_parts + $total_card_details_used_parts + $total_card_details_tax ;
                $total_expenses = $total_expenses_cash + $total_expenses_network ;
                $total_custody_administration = $total_custody_administration_cash + $total_custody_administration_network ;
                $total_advances_and_salaries = $total_advances_and_salaries_cash + $total_advances_and_salaries_network ;
                $moneySafeOpeningBalance = MoneySafeOpeneingBalance::where('branch_id', $branch_id) -> whereDate('updated_at', $start_date)->first('balance') -> balance ?? 0;
                return view('admin.statement.tableOfStatement',
                    compact(
                        'statements',
                        'total_imports_cash',
                        'total_imports_network',
                        'total_imports_bank_transfer',
                        'total_card_details_hand_labour',
                        'total_card_details_new_parts',
                        'total_card_details_used_parts',
                        'total_card_details_tax',
                        'total_expenses_cash',
                        'total_expenses_network',
                        'total_custody_administration_cash',
                        'total_custody_administration_network',
                        'total_cash_to_administration',
                        'total_advances_and_salaries_cash',
                        'total_advances_and_salaries_network',
                        'total_imports',
                        'total_card_details',
                        'total_expenses',
                        'total_custody_administration',
                        'total_advances_and_salaries',
                        'moneySafeOpeningBalance'
                    ));
            }else
            {
                return '<div class="text-center alert alert-warning">No Data Available .</div>';
            }


//            return view('admin.statement.tableOfStatement');
        }
    }

    public function index()
    {
//        $branch_id = auth()->user()->branch_id ?? \request('branch_id');
//        $date = Carbon::today();
//        $statements = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->get();
//        $total_imports_cash = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('imports_cash');
//        $total_imports_network = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('imports_network');
//        $total_imports_bank_transfer = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('imports_bank_transfer');
//        $total_card_details_hand_labour = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('card_details_hand_labour');
//        $total_card_details_new_parts = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('card_details_new_parts');
//        $total_card_details_used_parts = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('card_details_used_parts');
//        $total_card_details_tax = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('card_details_tax');
//        $total_expenses_cash = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('expenses_cash');
//        $total_expenses_network = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('expenses_network');
//        $total_custody_administration_cash = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('custody_administration_cash');
//        $total_custody_administration_network = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('custody_administration_network');
//        $total_cash_to_administration = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('cash_to_administration');
//        $total_advances_and_salaries_cash = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('advances_and_salaries_cash');
//        $total_advances_and_salaries_network = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('advances_and_salaries_network');
//        $total_imports = $total_imports_cash + $total_imports_network + $total_imports_bank_transfer ;
//        $total_card_details = $total_card_details_hand_labour + $total_card_details_new_parts + $total_card_details_used_parts + $total_card_details_tax ;
//        $total_expenses = $total_expenses_cash + $total_expenses_network ;
//        $total_custody_administration = $total_custody_administration_cash + $total_custody_administration_network ;
//        $total_advances_and_salaries = $total_advances_and_salaries_cash + $total_advances_and_salaries_network ;
//        $moneySafeOpeningBalance = MoneySafeOpeneingBalance::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->first('balance') -> balance ?? 0;
//        return view('admin.statement.index',
//            compact(
//                'statements',
//                'total_imports_cash',
//                'total_imports_network',
//                'total_imports_bank_transfer',
//                'total_card_details_hand_labour',
//                'total_card_details_new_parts',
//                'total_card_details_used_parts',
//                'total_card_details_tax',
//                'total_expenses_cash',
//                'total_expenses_network',
//                'total_custody_administration_cash',
//                'total_custody_administration_network',
//                'total_cash_to_administration',
//                'total_advances_and_salaries_cash',
//                'total_advances_and_salaries_network',
//                'total_imports',
//                'total_card_details',
//                'total_expenses',
//                'total_custody_administration',
//                'total_advances_and_salaries',
//                'moneySafeOpeningBalance'
//            ));
        $branch_list = Branch::all(['id', 'display_name']);
        return view('admin.statement.index', compact('branch_list'));
    }

//    public function selectBranch()
//    {
//        $branches = Branch::pluck('name', 'id');
//        return view('admin.statement.selectBranch', compact('branches'));
//    }

    public function statement_print()
    {
        $branch_id = auth()->user()->branch_id ?? \request('branch_id');
        $date = Carbon::today();

        $data['statements'] = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->get();
        $data['total_imports_cash'] = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('imports_cash');
        $data['total_imports_network'] = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('imports_network');
        $data['total_imports_bank_transfer'] = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('imports_bank_transfer');
        $data['total_card_details_hand_labour'] = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('card_details_hand_labour');
        $data['total_card_details_new_parts'] = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('card_details_new_parts');
        $data['total_card_details_used_parts'] = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('card_details_used_parts');
        $data['total_card_details_tax'] = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('card_details_tax');
        $data['total_expenses_cash'] = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('expenses_cash');
        $data['total_expenses_network'] = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('expenses_network');
        $data['total_custody_administration_cash'] = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('custody_administration_cash');
        $data['total_custody_administration_network'] = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('custody_administration_network');
        $data['total_cash_to_administration'] = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('cash_to_administration');
        $data['total_advances_and_salaries_cash'] = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('advances_and_salaries_cash');
        $data['total_advances_and_salaries_network'] = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->sum('advances_and_salaries_network');
        $data['total_imports'] = $data['total_imports_cash'] + $data['total_imports_network'] + $data['total_imports_bank_transfer'] ;
        $data['total_card_details'] = $data['total_card_details_hand_labour'] + $data['total_card_details_new_parts'] + $data['total_card_details_used_parts'] + $data['total_card_details_tax'] ;
        $data['total_expenses'] = $data['total_expenses_cash'] + $data['total_expenses_network'] ;
        $data['total_custody_administration'] = $data['total_custody_administration_cash'] + $data['total_custody_administration_network'] ;
        $data['total_advances_and_salaries'] = $data['total_advances_and_salaries_cash'] + $data['total_advances_and_salaries_network'] ;
        $data['moneySafeOpeningBalance'] = MoneySafeOpeneingBalance::where('branch_id', $branch_id) -> whereDate('updated_at', $date)->first('balance') -> balance ?? 0;


//        $data = [];
//        $data['sale_order'] = SaleOrder::findOrFail($saleOrderId);
        $mpdf = PDF::loadView('admin.statement.statement_print', $data, [], [
            'margin_top' => 40,
            'margin_header' => 10,
            'margin_footer' => 20,

        ]);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoArabic = true;
        $mpdf->autoLangToFont = true;
        $mpdf->showImageErrors = true;
        $mpdf->setAutoBottomMargin = true;
//         $mpdf->download($data['sale_order']->invoice_number.'.pdf');
//        if ($request->download)
//        {
//            return $mpdf->download($data['sale_order']->invoice_number.'.pdf');
//
//        }
//        return $mpdf->stream($data['sale_order']->invoice_number.'.pdf');
        return $mpdf->stream('Statement.pdf');

//        dd('Print Statement');
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Statement $statement)
    {
        //
    }

    public function edit(Statement $statement)
    {
        //
    }

    public function update(Request $request, Statement $statement)
    {
        //
    }

    public function destroy(Statement $statement)
    {
        //
    }
}

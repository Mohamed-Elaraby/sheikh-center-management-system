<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatementController extends Controller
{
    public function index()
    {
        $branch_id = 4;
        $date = '2023-12-26';
        $statements = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', Carbon::parse($date))->get();
        $total_imports_cash = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', Carbon::parse($date))->sum('imports_cash');
        $total_imports_network = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', Carbon::parse($date))->sum('imports_network');
        $total_imports_bank_transfer = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', Carbon::parse($date))->sum('imports_bank_transfer');
        $total_card_details_hand_labour = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', Carbon::parse($date))->sum('card_details_hand_labour');
        $total_card_details_new_parts = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', Carbon::parse($date))->sum('card_details_new_parts');
        $total_card_details_used_parts = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', Carbon::parse($date))->sum('card_details_used_parts');
        $total_card_details_tax = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', Carbon::parse($date))->sum('card_details_tax');
        $total_expenses_cash = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', Carbon::parse($date))->sum('expenses_cash');
        $total_expenses_network = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', Carbon::parse($date))->sum('expenses_network');
        $total_custody_administration_cash = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', Carbon::parse($date))->sum('custody_administration_cash');
        $total_custody_administration_network = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', Carbon::parse($date))->sum('custody_administration_network');
        $total_cash_to_administration = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', Carbon::parse($date))->sum('cash_to_administration');
        $total_advances_and_salaries_cash = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', Carbon::parse($date))->sum('advances_and_salaries_cash');
        $total_advances_and_salaries_network = Statement::where('branch_id', $branch_id) -> whereDate('updated_at', Carbon::parse($date))->sum('advances_and_salaries_network');
        $total_imports = $total_imports_cash + $total_imports_network + $total_imports_bank_transfer ;
        $total_card_details = $total_card_details_hand_labour + $total_card_details_new_parts + $total_card_details_used_parts + $total_card_details_tax ;
        $total_expenses = $total_expenses_cash + $total_expenses_network ;
        $total_custody_administration = $total_custody_administration_cash + $total_custody_administration_network ;
        $total_advances_and_salaries = $total_advances_and_salaries_cash + $total_advances_and_salaries_network ;
        return view('admin.statement.index',
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
            ));
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

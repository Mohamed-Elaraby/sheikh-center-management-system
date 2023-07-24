<?php

namespace App\Http\Controllers\Employee;

use App\DataTables\DiscountDatatable;
use App\Interfaces\moneySafe\balance;
use App\Models\Discount;
use App\Models\Employee;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read-discounts')->only('index');
        $this->middleware('permission:create-discounts')->only('create');
        $this->middleware('permission:update-discounts')->only('edit');
        $this->middleware('permission:delete-discounts')->only('destroy');
    }

    public function index(DiscountDatatable $discountDatatable, Request $request)
    {
        $employeeName = '';
        if ($request->employee_id) // Get all check with [ check status id ] from request url
            $employeeName = Employee::findOrFail($request->employee_id)->name; // Get [ check status name ] to send into view
        return $discountDatatable -> render('employee.discounts.index', compact('employeeName'));
    }

    public function create(Request $request)
    {
        $employee_id = $request->employee_id;
        $employee = Employee::findOrFail($employee_id);
        return view('employee.discounts.create', compact('employee'));
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $branch_id = Employee::findOrFail($request -> employee_id)->branch_id;
        $amount = $request ->amount;
        Discount::create($request -> all()+ ['user_id' => $user_id]);
//        $money_safe = new balance();
//        $check_balance = $money_safe -> checkBalance($amount, $branch_id);
//        if ($check_balance)
//        {
//            return redirect() -> route('employee.advances.index') -> with('delete', __('trans.the amount in the safe is not enough'));
//        }else
//        {
//
//            $money_safe -> decreaseBalance($discount, $amount, $branch_id);
//        }


        return redirect() -> route('employee.discounts.index') -> with('success', __('trans.discount added successfully'));
    }

    public function show($id)
    {
        $discount = Discount::findOrFail($id);
        return view('employee.discounts.show', compact('discount'));
    }

    public function edit($id)
    {
        $discount = Discount::findOrFail($id);
        return view('employee.discounts.edit',compact('discount'));
    }

    public function update(Request $request, $id)
    {
        $discount = Discount::findOrFail($id);
        $discount->update($request -> all());
        return redirect() -> route('employee.discounts.index') -> with('success', __('trans.discount edit successfully'));
    }

    public function destroy($id)
    {
        Discount::findOrFail($id) -> delete();
        return redirect()->back()->with('delete', __('trans.discount delete successfully'));
    }
}

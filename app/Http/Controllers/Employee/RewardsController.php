<?php

namespace App\Http\Controllers\Employee;

use App\DataTables\RewardDatatable;
use App\Interfaces\bank\balance as balanceOfBank;
use App\Interfaces\moneySafe\balance;
use App\Models\Branch;
use App\Models\Employee;
use App\Models\Reward;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RewardsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read-rewards')->only('index');
        $this->middleware('permission:create-rewards')->only('create');
        $this->middleware('permission:update-rewards')->only('edit');
        $this->middleware('permission:delete-rewards')->only('destroy');
    }

    public function index(RewardDatatable $rewardDatatable, Request $request)
    {

        $employeeName = '';
        if ($request->employee_id) // Get all check with [ check status id ] from request url
            $employeeName = Employee::findOrFail($request->employee_id)->name; // Get [ check status name ] to send into view
        return $rewardDatatable -> render('employee.rewards.index', compact('employeeName'));
    }

    public function create(Request $request)
    {
        $employee_id = $request->employee_id;
        $employee = Employee::findOrFail($employee_id);
        return view('employee.rewards.create', compact('employee'));
    }

    public function store(Request $request)
    {
//        dd($request->all());

        $user_id = Auth::user()->id;
        $branch_id = Employee::findOrFail($request -> employee_id)->branch_id;
        $amount = $request ->amount;

//        $reward = Reward::create($request -> all() + ['user_id' => $user_id]);
        if ($request->type == 'يحصل عليها العامل فورا')
        {
            $payment_method = $request -> payment_method;

            if ($payment_method === 'cash')
            {
                $money_safe = new balance();
                $check_balance = $money_safe -> checkBalance($amount, $branch_id);
                if ($check_balance)
                {
                   return redirect() -> route('employee.rewards.index') -> with('delete', __('trans.the amount in the safe is not enough'));
                }else
                {
                    $reward = Reward::create($request -> all() + ['user_id' => $user_id, 'status' => 'حصل عليها العامل فورا']);
                    $money_safe -> increaseBalance($reward, $amount, $branch_id);
                }

            }else
            {
                $bank = new balanceOfBank();
                $check_balance = $bank -> checkBalance($amount, $branch_id);

                if ($check_balance)
                {
                    return redirect() -> route('employee.rewards.index') -> with('delete', __('trans.the amount in the bank is not enough'));
                }else
                {
                    $reward = Reward::create($request -> all() + ['user_id' => $user_id, 'status' => 'حصل عليها العامل فورا']);
                    $bank -> decreaseBalance($reward, $amount, $branch_id);
                }
            }

//            $reward->update(['status' => 'حصل عليها العامل فورا']);
        }else
        {
//            dd($request->all());
            Reward::create($request -> all() + ['user_id' => $user_id]);
        }
        return redirect() -> route('employee.rewards.index') -> with('success', __('trans.reward added successfully'));

    }

    public function show($id)
    {
        $reward = Reward::findOrFail($id);
        return view('employee.rewards.show', compact('reward'));
    }

    public function edit($id)
    {
        $reward = Reward::findOrFail($id);
        return view('employee.rewards.edit',compact('reward'));
    }

    public function update(Request $request, $id)
    {
//        dd($request -> all());
        $reward = Reward::findOrFail($id);
        $reward->update($request -> all());
        return redirect() -> route('employee.rewards.index') -> with('success', __('trans.reward edit successfully'));
    }

    public function destroy($id)
    {
        Reward::findOrFail($id) -> delete();
        return redirect()->back()->with('delete', __('trans.reward delete successfully'));
    }
}

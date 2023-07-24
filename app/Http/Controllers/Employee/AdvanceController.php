<?php

namespace App\Http\Controllers\Employee;

use App\DataTables\Advancedatatable;
use App\Interfaces\advance\Make;
use App\Interfaces\advance\Scheduled;
use App\Interfaces\bank\balance as balanceOfBank;
use App\Interfaces\moneySafe\balance;
use App\Interfaces\bank\balance as changeBalanceOfBank;
use App\Models\Advance;
use App\Models\Employee;
use App\Models\ScheduledAdvance;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdvanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read-advances')->only('index');
        $this->middleware('permission:create-advances')->only('create');
        $this->middleware('permission:update-advances')->only('edit');
        $this->middleware('permission:delete-advances')->only('destroy');
    }

    public function index(Advancedatatable $advancedatatable, Request $request)
    {
        $employeeName = '';
        if ($request->employee_id) // Get all check with [ check status id ] from request url
            $employeeName = Employee::findOrFail($request->employee_id)->name; // Get [ check status name ] to send into view
        return $advancedatatable -> render('employee.advances.index', compact('employeeName'));
    }

    public function create(Request $request)
    {
        $employee_id = $request->employee_id;
        $employee = Employee::findOrFail($employee_id);
        return view('employee.advances.create', compact('employee'));
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $user_id = Auth::user()->id;
        $advance_type = $request->type;
        $branch_id = Employee::findOrFail($request -> employee_id)->branch_id;
        $amount = $request ->amount;

        if ($advance_type == 'تخصم مباشرة'){
            $payment_method = $request -> payment_method;
            if ($payment_method === 'cash')
            {
                $money_safe = new balance();
                $check_balance = $money_safe -> checkBalance($amount, $branch_id);
                if ($check_balance)
                {
                    return redirect() -> route('employee.advances.index') -> with('delete', __('trans.the amount in the safe is not enough'));
                }else
                {
                    $reward = Advance::create($request -> all() + ['user_id' => $user_id, 'status' => 'مسددة بالكامل']);
                    $money_safe -> decreaseBalance($reward, $amount, $branch_id);
                }


            }else
            {
                $bank = new balanceOfBank();
                $check_balance = $bank -> checkBalance($amount, $branch_id);

                if ($check_balance)
                {
                    return redirect() -> route('employee.advances.index') -> with('delete', __('trans.the amount in the bank is not enough'));
                }else
                {
                    $reward = Advance::create($request -> all() + ['user_id' => $user_id, 'status' => 'مسددة بالكامل']);
                    $bank -> decreaseBalance($reward, $amount, $branch_id);
                }
            }
        }else
        {
            $advance = Advance::create($request -> except(['single_amount', 'pay_method']) + ['user_id' => $user_id] + ['status' => 'غير مسددة']);
            if ($request -> single_amount)
            {
                $single_amount = $request -> single_amount;
                foreach ($single_amount as $amount) {
                    $sc = new Make();
                    $sc -> createScheduled($amount, $advance -> id, $user_id);
                }
            }
        }

        return redirect() -> route('employee.advances.index') -> with('success', __('trans.advance added successfully'));
    }

    public function show($id)
    {
        $advance = Advance::findOrFail($id);
        return view('employee.advances.show', compact('advance'));
    }

    public function edit($id)
    {
        $advance = Advance::findOrFail($id);
        return view('employee.advances.edit',compact('advance'));
    }

    public function update(Request $request, $id)
    {
        $advance = Advance::findOrFail($id);
        $advance->update($request -> all());
        return redirect() -> route('employee.advances.index') -> with('success', __('trans.advance edit successfully'));
    }

    public function destroy($id)
    {
        Advance::findOrFail($id) -> delete();
        return redirect()->back()->with('delete', __('trans.advance delete successfully'));
    }

    public function scheduling_details(Request $request)
    {
        $advance_id = $request->advance_id;
        $scheduled_advances = ScheduledAdvance::where('advance_id', $advance_id)->get();

        dd($scheduled_advances);
    }

}

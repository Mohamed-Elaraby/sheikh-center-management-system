<?php


namespace App\Interfaces\salary;


use App\Models\Car;
use App\Models\EmployeeSalaryLog;
use App\Models\Images;
use App\Models\Salary;
use Carbon\Carbon;
use PDF;

class Calculate implements Operations
{

    public function totalSalary($employee_id)
    {
        $salary = Salary::where('employee_id', $employee_id)
            ->first(['main', 'housing_allowance', 'transfer_allowance', 'travel_allowance', 'end_service_allowance', 'other_allowance']);
        return array_sum($salary->toArray()) ;
    }

    public function salaryPerDay($totalSalary)
    {
        $number_days_of_month = Carbon::now()->daysInMonth;
        $employee_salary_per_day = $totalSalary / $number_days_of_month ;
        return number_format($employee_salary_per_day, 2);
    }

    public function printSalaryMonthDetails($employee_salary_log)
    {
        $employee_salary_log_id = $employee_salary_log;
//        $data = [];
        $data['employee_salary_log'] = EmployeeSalaryLog::findOrFail($employee_salary_log_id);
        $data['employee_salary_signature'] = Images::where('employee_salary_log_id',$employee_salary_log_id)->where('type',5) -> latest() -> first();
        $mpdf = PDF::loadView('employee.salaries.salary_month_details_print', $data, [], [
            'margin_top' => 100,
            'margin_header' => 10,
            'margin_footer' => 20,

        ]);
        $mpdf->autoScriptToLang = true;
        $mpdf->autoArabic = true;
        $mpdf->autoLangToFont = true;
        $mpdf->showImageErrors = true;
        $mpdf->setAutoBottomMargin = true;

        $employee_name = $data['employee_salary_log']->employee -> name ;
        $month = Carbon::parse($data['employee_salary_log']->salary_month)->month;
        $year = Carbon::parse($data['employee_salary_log']->salary_month)->year;
//         $mpdf->download($data['sale_order']->invoice_number.'.pdf');
//        if ($request->download)
//        {
//            return $mpdf->download($employee_name . ' - ' .$month. ' - ' .$year.'.pdf');
//
//        }

        return $mpdf->stream($employee_name . ' - ' .$month. ' - ' .$year.'.pdf');
    }
}

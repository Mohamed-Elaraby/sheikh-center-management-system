<?php


namespace App\Interfaces\salary;


interface Operations
{
    public function totalSalary($employee_id);

    public function salaryPerDay($totalSalary);

    public function printSalaryMonthDetails($employee_salary_log_id);
}

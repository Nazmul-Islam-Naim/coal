<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeSalaryBill extends Model
{
    protected $table = "employee_salary_bill";
    protected $fillable = [
     	'employee_id', 'basic_amount', 'additional_amount', 'amount', 'month_name', 'year_name', 'note', 'date', 'created_by'
    ];

    public function ledger_user_object()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function bill_employee_object()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeLedger extends Model
{
    protected $table = "employee_ledger";
    protected $fillable = [
     	'bill_id', 'date', 'bank_id', 'employee_id', 'month', 'year', 'amount', 'reason', 'tok', 'note', 'created_by'
    ];

    public function ledger_user_object()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function ledger_employee_object()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id');
    }
}

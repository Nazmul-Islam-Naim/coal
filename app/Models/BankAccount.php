<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $table = "bank_account";
    protected $fillable = [
    	'bank_name', 'account_name', 'account_no', 'account_type', 'bank_branch', 'balance', 'opening_date', 'status', 'created_by'
    ];

    public function bankaccount_accounttype_object()
    {
        return $this->hasOne('App\Models\AccountType', 'id', 'account_type');

    }
}
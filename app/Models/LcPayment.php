<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LcPayment extends Model
{
    protected $table = "lc_payments";
    protected $fillable = [
    	'date','lc_id','lc_no','bank_id','bank_due','dollar_rate','amount','note','status','created_by','tok'
    ];

    public function bankaccount_accounttype_object()
    {
        return $this->hasOne('App\Models\AccountType', 'id', 'account_type');

    }
}
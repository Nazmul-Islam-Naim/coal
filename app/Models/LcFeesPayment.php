<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LcFeesPayment extends Model
{
    protected $table = "lc_fees_payment";
    protected $fillable = [
    	'date','bank_id','lc_id','lc_no','fees_type_id','amount','tok','note','created_by','status'
    ];

    public function bankaccount_accounttype_object()
    {
        return $this->hasOne('App\Models\AccountType', 'id', 'account_type');

    }
}
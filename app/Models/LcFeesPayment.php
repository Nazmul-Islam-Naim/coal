<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LcFeesPayment extends Model
{
    protected $table = "lc_fees_payment";
    protected $fillable = [
    	'date','bank_id','lc_id','lc_no','fees_type_id','amount','tok','note','created_by','status'
    ];

    public function bank()
    {
        return $this->belongsTo(BankAccount::class);

    }

    public function feesType(){
        return $this->belongsTo(FeeType::class, 'fees_type_id');
    }
}
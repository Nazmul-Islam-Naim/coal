<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionReport extends Model
{
    protected $table = "transation_report";
    protected $fillable = [
    	'bank_id', 'transaction_date', 'amount', 'reason', 'note', 'tok', 'status', 'created_by'
    ];

    public function transactionreport_bank_object()
    {
        return $this->hasOne('App\Models\BankAccount', 'id', 'bank_id');
    }
}

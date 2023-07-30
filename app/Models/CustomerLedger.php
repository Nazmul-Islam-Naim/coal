<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerLedger extends Model
{
    protected $table = "customer_ledger";
    protected $fillable = [
     	'date', 'bank_id', 'customer_id', 'truck_no', 'quantity', 'unit_price', 'amount', 'reason', 'note', 'tok', 'created_by'
    ];

    public function ledger_user_object()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function ledger_customer_object()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }
    
    public function ledger_bank_object()
    {
        return $this->hasOne('App\Models\BankAccount', 'id', 'bank_id');
    }
}

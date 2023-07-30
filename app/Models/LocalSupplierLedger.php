<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalSupplierLedger extends Model
{
    protected $table = 'local_supplier_ledgers';
    protected $fillable = [
        'local_supplier_id', 'bank_account_id', 'date', 'reason', 'amount', 'note'
    ];

    // realtionship
    public function localSupplier(){
        return $this->belongsTo(LocalSupplier::class);
    }
    public function bankAccount(){
        return $this->belongsTo(BankAccount::class);
    }
}

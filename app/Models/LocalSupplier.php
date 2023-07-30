<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalSupplier extends Model
{
    protected $table = 'local_suppliers';
    protected $fillable = [
        'name', 'phone', 'email', 'address', 'bill', 'payment', 'due'
    ];

    // relationship
    public function preDue(){
        return $this->hasOne(LocalSupplierLedger::class);
    }
    public function ledger(){
        return $this->hasMany(LocalSupplierLedger::class);
    }
}

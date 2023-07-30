<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalSupplierLedger extends Model
{
    protected $table = 'local_supplier_ledgers';
    protected $fillable = [
        'local_supplier_id', 'date', 'reason', 'amount', 'note'
    ];

    // realtionship
    public function localSupplier(){
        return $this->belongsTo(LocalSupplier::class);
    }
}

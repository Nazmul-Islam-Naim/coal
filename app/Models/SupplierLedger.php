<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierLedger extends Model
{
    protected $table = "supplier_ledger";
    protected $fillable = [
     	'date', 'rs_id', 'supplier_id', 'amount', 'reason', 'note', 'tok', 'created_by'
    ];

    public function ledger_supplier_object()
    {
        return $this->hasOne('App\Models\Supplier', 'id', 'supplier_id');
    }

    public function ledger_user_object()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }
}

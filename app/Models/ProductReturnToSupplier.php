<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReturnToSupplier extends Model
{
    protected $table = "product_return_to_supplier";
    protected $fillable = [
    	'bank_id', 'total_qnty', 'supplier_id', 'net_return_amount', 'reason', 'return_date', 'tok', 'created_by'
    ];

    public function productreturntosupplier_supplier_object()
    {
        return $this->hasOne('App\Models\Supplier', 'id', 'supplier_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    protected $table = "product_purchase";
    protected $fillable = [
    	'supplier_id', 'total_qnty', 'sub_total', 'discount', 'purchase_date', 'note', 'tok', 'created_by'
    ];

    public function productpurchase_supplier_object()
    {
        return $this->hasOne('App\Models\Supplier', 'id', 'supplier_id');
    }
    public function productpurchase_createdby_object()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }
}

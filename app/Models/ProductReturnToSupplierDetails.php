<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReturnToSupplierDetails extends Model
{
    protected $table = "product_return_to_supplier_details";
    protected $fillable = [
    	'supplier_id', 'product_id', 'return_qnty', 'unit_price', 'tok', 'created_by'
    ];
    
    public function productreturndetail_supplier_object()
    {
        return $this->hasOne('App\Models\Supplier', 'id', 'supplier_id');
    }
    
    public function productreturndetail_product_object()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}

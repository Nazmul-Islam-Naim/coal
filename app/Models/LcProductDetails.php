<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LcProductDetails extends Model
{
    protected $table = "lc_product_details";
    protected $fillable = [
    	'lc_id', 'product_type_id', 'product_id', 'unit_price', 'quantity', 'tok', 'created_by'
    ];
    public function lc_producttype_object()
    {
        return $this->hasOne('App\Models\ProductType', 'id', 'product_type_id');
    }
    public function lc_product_object()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}

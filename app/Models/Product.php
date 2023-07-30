<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "product";
    protected $fillable = [
    	'name', 'product_type_id', 'unit_id', 'description', 'status'
    ];

    public function product_type_object()
    {
        return $this->hasOne('App\Models\ProductType', 'id', 'product_type_id');
    }
   
    public function product_unit_object()
    {
        return $this->hasOne('App\Models\ProductUnit', 'id', 'unit_id');
    }
}

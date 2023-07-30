<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSubType extends Model
{
    protected $table = "product_sub_type";
    protected $fillable = [
    	'product_type_id', 'name', 'status'
    ];

    public function productsubtype_type_object()
    {
        return $this->hasOne('App\Models\ProductType', 'id', 'product_type_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPackage extends Model
{
    protected $table = "product_package";
    protected $fillable = [
    	'food_type', 'package_code', 'name', 'details', 'image', 'price', 'status'
    ];

    public function productpackage_foodtype_object()
    {
        return $this->hasOne('App\Models\FoodType', 'id', 'food_type');

    }
}

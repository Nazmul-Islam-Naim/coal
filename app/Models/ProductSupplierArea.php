<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSupplierArea extends Model
{
    protected $table = "product_supplier_area";
    protected $fillable = [
    	'name', 'status'
    ];
}

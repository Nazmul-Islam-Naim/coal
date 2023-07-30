<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockProduct extends Model
{
    protected $table = "stock_product";
    protected $fillable = [
    	'branch_id', 'product_id', 'quantity', 'unit_price', 'status'
    ];

    public function stockproduct_product_object()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');

    }
}

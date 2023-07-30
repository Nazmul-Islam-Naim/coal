<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockProductDetail extends Model
{
    protected $table = "stock_product_details";
    protected $fillable = [
       'date', 'branch_id', 'product_type_id', 'product_id', 'quantity', 'unit_price', 'reason', 'tok', 'note', 'status'
    ];

    public function stockproduct_product_object()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');

    }
}

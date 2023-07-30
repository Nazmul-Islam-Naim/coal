<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSellDetails extends Model
{
    protected $table = "product_sell_details";
    protected $fillable = [
    	'customer_id', 'product_id', 'truck_no', 'unit_price', 'quantity', 'sell_date',	'tok', 'created_by'
    ];

    public function productsell_customer_object()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');

    }
    public function productsell_product_object()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');

    }
    
    public function productsell_user_object()
    {
        return $this->hasOne('App\User', 'id', 'created_by');

    }
}

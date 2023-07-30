<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSell extends Model
{
    protected $table = "product_sell";
    protected $fillable = [
    	'customer_id', 'sell_date', 'note', 'branch_id', 'total_qnty', 'sub_total', 'paid_amount', 'bank_id', 'tok', 'created_by'
    ];

    public function productsell_customer_object()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }

    public function productsell_user_object()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }
}
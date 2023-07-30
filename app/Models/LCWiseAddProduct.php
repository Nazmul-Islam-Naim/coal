<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LCWiseAddProduct extends Model
{
    protected $table = "add_product_lc_wise";
    protected $fillable = [
        'lc_id',
        'truck_no',
        'height',
        'width',
        'length',
        'converter',
        'quantity',
        'unit_price_dollar',
        'total_dollar',
        'dollar_rate_bdt',
        'total_bdt',
        'rupee_rate',
        'total_rs',
        'date',
        'tok',
        'created_by',
        'status',
    ];
    
    public function lc_details_object()
    {
        return $this->hasOne('App\Models\lcInfo', 'id', 'lc_id');
    }
}

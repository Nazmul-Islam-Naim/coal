<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftPoint extends Model
{
    protected $table = "gift_point";
    protected $fillable = [
    	'customer_id', 'bill_amount', 'achieve_point', 'date', 'tok'
    ];

    public function giftpoint_customer_object()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');

    }
}

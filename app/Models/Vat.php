<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vat extends Model
{
    protected $table = "vat_calculation";
    protected $fillable = [
    	'sub_total', 'discount_percent', 'discount_amount', 'vat_percent', 'vat_amount', 'grand_total', 'sell_date', 'payment_method', 'tok', 'created_by'
    ];

    public function vat_user_object()
    {
        return $this->hasOne('App\User', 'id', 'created_by');

    }
}

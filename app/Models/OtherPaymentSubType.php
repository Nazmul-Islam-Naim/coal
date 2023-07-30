<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherPaymentSubType extends Model
{
    protected $table = "other_payment_sub_type";
    protected $fillable = [
    	'payment_type_id', 'name', 'status'
    ];

    public function paymentsubtype_type_object()
    {
        return $this->hasOne('App\Models\OtherPaymentType', 'id', 'payment_type_id');
    }
}

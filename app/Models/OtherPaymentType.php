<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherPaymentType extends Model
{
    protected $table = "other_payment_type";
    protected $fillable = [
    	'name', 'status'
    ];
}

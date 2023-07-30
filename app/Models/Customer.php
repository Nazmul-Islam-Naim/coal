<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = "customer";
    protected $fillable = [
    	'customer_id', 'name', 'company', 'phone', 'address', 'pre_due', 'pre_due_date', 'status'
    ];
}

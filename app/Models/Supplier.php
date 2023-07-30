<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = "supplier";
    protected $fillable = [
    	'supplier_id', 'name', 'company', 'phone', 'address', 'pre_due', 'predue_date', 'status'
    ];
}

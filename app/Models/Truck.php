<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $table = "trucks";
    protected $fillable = [
    	'name','number','price','status'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodType extends Model
{
    protected $table = "food_type";
    protected $fillable = [
    	'name', 'status'
    ];
}

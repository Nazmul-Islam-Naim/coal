<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Border extends Model
{
    protected $table = "borders";
    protected $fillable = [
    	'name', 'status'
    ];
}

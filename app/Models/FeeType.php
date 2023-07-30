<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    protected $table = "fees_type";
    protected $fillable = [
    	'name', 'status'
    ];
}

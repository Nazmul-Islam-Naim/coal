<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exporter extends Model
{
    protected $table = "exporters";
    protected $fillable = [
    	'name','phone','address','status'
    ];
}

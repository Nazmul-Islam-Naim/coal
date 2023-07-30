<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chalan extends Model
{
    protected $table = "chalan_info";
    protected $fillable = [
    	'buyer_name','address','chalan_from','chalan_to','date','note','details','truck_no','length','width','height','cft','mt'
    ];
}

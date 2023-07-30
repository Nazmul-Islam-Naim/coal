<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherReceiveType extends Model
{
    protected $table = "other_receive_type";
    protected $fillable = [
    	'name', 'status'
    ];
}

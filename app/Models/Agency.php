<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $table = "agencies";
    protected $fillable = [
    	'agency_id', 'agency_name', 'owner_name', 'phone','email', 'address', 'pre_due', 'predue_date'
    ];
}

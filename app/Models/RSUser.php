<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RSUser extends Model
{
    protected $table = "rs_users";
    protected $fillable = [
    	'name', 'company', 'phone', 'address', 'pre_due', 'predue_date', 'status'
    ];
}

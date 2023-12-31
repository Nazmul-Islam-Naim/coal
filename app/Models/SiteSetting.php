<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $table = "site_setting";
    protected $fillable = [
    	'company_name', 'address', 'phone', 'email', 'note', 'image'
    ];
}

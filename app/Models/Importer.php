<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Importer extends Model
{
    protected $table = "importers";
    protected $fillable = [
    	'importer_id', 'name', 'company', 'phone', 'address', 'pre_due', 'predue_date', 'status'
    ];
}

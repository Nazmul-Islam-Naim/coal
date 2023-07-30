<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transaction";
    protected $fillable = [
    	'date', 'reason', 'amount', 'reason', 'tok', 'status', 'created_by'
    ];
}

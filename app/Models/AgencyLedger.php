<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgencyLedger extends Model
{
    protected $table = "agency_ledger";
    protected $fillable = [
    	'date', 'bank_id', 'agency_id', 'amount', 'reason', 'tok', 'created_by'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RSUserLedger extends Model
{
    protected $table = "rs_user_ledger";
    protected $fillable = [
     	'date', 'bank_id', 'rs_id', 'rs_amount', 'rs_rate', 'amount', 'reason', 'note', 'tok', 'created_by'
    ];

    public function ledger_rs_object()
    {
        return $this->hasOne('App\Models\RSUser', 'id', 'rs_id');
    }

    public function ledger_user_object()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }
}

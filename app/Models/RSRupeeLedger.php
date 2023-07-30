<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RSRupeeLedger extends Model
{
    protected $table = "rs_rupee_ledger";
    protected $fillable = [
     	'date', 'bank_id', 'rs_id', 'exporter_id', 'amount', 'reason', 'note', 'tok', 'created_by'
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

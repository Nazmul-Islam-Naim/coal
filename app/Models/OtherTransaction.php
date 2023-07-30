<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherTransaction extends Model
{
    protected $table = "other_transaction";
    protected $fillable = [
    	'method', 'type', 'transaction_for', 'amount', 'transaction_date', 'issue_by', 'note', 'reason', 'status', 'tok', 'created_by'
    ];

    public function othertransaction_bank_object()
    {
        return $this->hasOne('App\Models\BankAccount', 'id', 'method');

    }
    public function othertransaction_type_object()
    {
        return $this->hasOne('App\Models\OtherTransactionType', 'id', 'type');

    }
}

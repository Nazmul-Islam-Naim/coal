<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chequebook extends Model
{
    protected $table = "cheque_book";
    protected $fillable = [
    	'name', 'bank', 'status'
    ];

    public function chequebook_bank_object()
    {
        return $this->hasOne('App\Models\BankAccount', 'id', 'bank');

    }
}

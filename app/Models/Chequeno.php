<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chequeno extends Model
{
    protected $table = "cheque_no";
    protected $fillable = [
    	'cheque_book', 'cheque_no', 'status', 'tok'
    ];

    public function chequeno_chequebook_object()
    {
        return $this->hasOne('App\Models\Chequebook', 'id', 'cheque_book');

    }
}

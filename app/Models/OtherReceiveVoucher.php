<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherReceiveVoucher extends Model
{
    protected $table = "other_receive_voucher";
    protected $fillable = [
    	'receive_type_id', 'receive_sub_type_id', 'bank_id', 'receive_from', 'amount', 'receive_date', 'issue_by', 'note', 'status', 'created_by', 'tok'
    ];

    public function otherreceive_bank_object()
    {
        return $this->hasOne('App\Models\BankAccount', 'id', 'bank_id');
    }
    public function otherreceive_type_object()
    {
        return $this->hasOne('App\Models\OtherReceiveType', 'id', 'receive_type_id');
    }
    public function otherreceive_subtype_object()
    {
        return $this->hasOne('App\Models\OtherReceiveSubType', 'id', 'receive_sub_type_id');
    }
    public function otherreceive_user_object()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }
}

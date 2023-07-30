<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellServiceDetails extends Model
{
    protected $table = "sell_service_details";
    protected $fillable = [
    	'customer_id', 'instruction', 'cost', 'technician_id', 'sell_date', 'tok', 'job_card_no', 'created_by'
    ];

    public function productsellservice_customer_object()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');

    }
    public function productsellservice_technician_object()
    {
        return $this->hasOne('App\Models\Technician', 'id', 'technician_id');

    }
    
    public function productsellservice_user_object()
    {
        return $this->hasOne('App\User', 'id', 'created_by');

    }
}

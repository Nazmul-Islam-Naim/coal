<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaveQuotation extends Model
{
    protected $table = "save_quotation";
    protected $fillable = [
    	'customer_id','job_card_no','job_card_date','receive_date_time','delivery_date_time','reg_no','car_band','car_engine','car_vin','car_odometer','total_amount','total_qnty','purchase_value','vat_percent','vat_amount','tok','created_by','status'
    ];

    public function productsell_customer_object()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }

    public function productsell_user_object()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }
}
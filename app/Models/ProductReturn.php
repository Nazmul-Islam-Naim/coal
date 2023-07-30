<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReturn extends Model
{
    protected $table = "product_return";
    protected $fillable = [
    	'customer_id', 'total_qnty', 'net_return_amount', 'reason', 'return_date', 'tok', 'invoice_no', 'created_by'
    ];

    public function productreturn_customer_object()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }
}

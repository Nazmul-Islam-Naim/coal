<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductWastageDetails extends Model
{
    protected $table = "product_wastage_details";
    protected $fillable = [
    	'customer_id', 'product_id', 'return_qnty', 'deduction_percent', 'total_amount', 'tok', 'created_by'
    ];

    public function productwastagedetails_customer_object()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }

    public function productwastagedetails_product_object()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReturnDetails extends Model
{
    protected $table = "product_return_details";
    protected $fillable = [
    	'customer_id', 'product_id', 'return_qnty', 'total_amount', 'tok', 'invoice_no', 'created_by'
    ];
    
    public function productreturndetail_product_object()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
    
    public function productreturndetail_cus_object()
    {
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }
}

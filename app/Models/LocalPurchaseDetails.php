<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalPurchaseDetails extends Model
{
    protected $table = 'local_purchase_details';
    protected $fillable = [
        'local_purchase_id', 'product_id', 'unit_price', 'quantity'
    ];

    //relationship
    public function purchase(){
        return $this->belongsTo(LocalPurchase::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}

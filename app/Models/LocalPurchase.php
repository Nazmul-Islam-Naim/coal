<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalPurchase extends Model
{
    protected $table = 'local_purchases';
    protected $fillable = [
        'local_supplier_id', 'amount', 'date', 'note', 'status', 'created_by'
    ];

    // relationship
    public function supplier(){
        return $this->belongsTo(LocalSupplier::class, 'local_supplier_id');
    }

    public function purchaseDetails(){
        return $this->hasMany(LocalPurchaseDetails::class);
    }

    public function stockProductDetails(){
        return $this->hasMany(StockProductDetail::class, 'tok');
    }
}

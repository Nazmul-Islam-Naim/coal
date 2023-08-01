<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LcProductStatus extends Model
{
    protected $table = 'lc_product_statuses';
    protected $fillable = [
        'lc_info_id', 'product_id', 'lc_no', 'total_quantity', 'receive_quantity', 'due_quantity', 'date'
    ];

    // relationship
    public function lcInfo(){
        return $this->belongsTo(lcInfo::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}

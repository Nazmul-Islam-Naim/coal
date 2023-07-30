<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDistributeToBranch extends Model
{
    protected $table = "product_distribute_to_branch";
    protected $fillable = [
    	'branch_id', 'product_id', 'quantity', 'lighter_agency_id', 'lighter_name', 'rent_per_ton', 'total_rent', 'departure_date', 'arrival_date', 'loading_date', 'unloading_date', 'date', 'note', 'tok', 'created_by'
    ];

    public function distribute_branch_object()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }
    public function distribute_product_object()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
    public function distribute_agency_object()
    {
        return $this->hasOne('App\Models\Agency', 'id', 'lighter_agency_id');
    }
}

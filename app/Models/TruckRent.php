<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckRent extends Model
{
    protected $table = "truck_rent";
    protected $fillable = [
    	'branch_id', 'truck_id', 'rent_amount', 'cost_amount', 'rent_from', 'rent_to', 'date', 'bank_id', 'note', 'created_by'
    ];
    
    public function truck_rent_object()
    {
        return $this->hasOne('App\Models\Truck', 'id', 'truck_id');
    }
    
    public function truck_rent_branch_object()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'branch_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lcInfo extends Model
{
    protected $table = "lc_info";
    protected $fillable = [
        'lc_no','bank_id','importer_id','exporter_id','origin_of_country','opening_date','expire_date','shipment_date','border_id','total_qnty','sub_total','dollar_rate','total_bdt','margin_percent','margin_amount','bank_due','commission','insurance','tok','created_by','status'
    ];
    
    public function lc_importer_object()
    {
        return $this->hasOne('App\Models\Importer', 'id', 'importer_id');
    }
    public function lc_exporter_object()
    {
        return $this->hasOne('App\Models\Supplier', 'id', 'exporter_id');
    }
    public function lc_border_object()
    {
        return $this->hasOne('App\Models\Branch', 'id', 'border_id');
    }
    public function lc_bank_object()
    {
        return $this->hasOne('App\Models\BankAccount', 'id', 'bank_id');
    }
}

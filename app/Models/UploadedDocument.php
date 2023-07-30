<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadedDocument extends Model
{
    protected $table = "uploaded_documents";
    protected $fillable = [
    	'exporter_id', 'customer_id', 'lc_id', 'name', 'status'
    ];
}

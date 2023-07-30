<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = "employees";
    protected $fillable = [
    	'employee_id', 'name', 'email', 'joining_date', 'contact', 'address', 'basic_salary', 'employee_image', 'status'
    ];
}
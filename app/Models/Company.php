<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'choice_number', 'company_name', 'company_nature', 
        'company_address', 'core_business', 'supervisor_approval'
    ];
}

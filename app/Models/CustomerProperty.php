<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerProperty extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'page_id','master_id','reference_id','reference_value','property_name','property_code', 'filling_cycle',
        'country','state','city','inserted_by','updated_by','status_active','is_deleted'
    ];
}

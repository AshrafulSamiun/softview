<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentialSuiteDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id','master_id','details_id','item_id','uom', 'item_size', 'item_name','property_name', 'system_prefix', 'system_no',
         'comments','inserted_by','updated_by','status_active','is_deleted'
    ];
}

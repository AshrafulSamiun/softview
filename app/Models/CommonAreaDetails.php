<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonAreaDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id','master_id','details_id','item_id','system_prefix','system_no','uom', 'item_size', 'item_name','allocated_size','property_name','comments', 
        'company','landlord','leasehold','other_1','other_2','inserted_by','updated_by','status_active','is_deleted'
    ];
}

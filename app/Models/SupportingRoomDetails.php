<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportingRoomDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id','master_id','floor_id','details_id','item_id','uom', 'item_size', 
         'item_name','item_type', 'property_name','system_no','allocated_size',
        'system_prefix','inserted_by','updated_by','status_active','is_deleted'
    ];
}

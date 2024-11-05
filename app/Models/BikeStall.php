<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeStall extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id','master_id','details_id','item_id','system_prefix','system_no','uom', 'item_size',  'item_name',
        'property_name','allocated','stall_type_1','stall_type_2','stall_type_3','stall_type_4','stall_type_5','stall_type_6',
        'stall_type_7','stall_type_8','stall_type_9','stall_type_10','stall_type_11','stall_type_12', 'inserted_by',
        'updated_by','status_active','is_deleted'
    ];
}

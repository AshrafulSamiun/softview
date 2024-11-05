<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id','master_id','details_id','system_prefix','system_no','uom', 'item_size',  'item_name',
        'property_name','building_name','storage_type_1','storage_type_2','storage_type_3','storage_type_4','storage_type_5','storage_type_6',
        'storage_type_7','storage_type_8','storage_type_9','storage_type_10','storage_type_11','storage_type_12', 
        'inserted_by','updated_by','status_active','is_deleted'
    ];
}

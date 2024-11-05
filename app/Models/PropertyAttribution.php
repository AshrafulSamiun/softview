<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAttribution extends Model
{
    use HasFactory;

   protected $fillable = ['id', 'project_id', 'company_name', 'customer_name', 'building_id', 
   'suite_id', 'unit_id', 'system_prefix','system_no', 'suite_size_qty', 'unit_size_qty', 
   'total_supporting_area','total_parking_stall_size', 'total_bike_stall_size', 
   'total_storage_locker_size','mailbox_size_qty', 'total_common_area', 'total_property_size_qty',
   'inserted_by', 'updated_by', 'status_active', 'is_deleted']; 

}

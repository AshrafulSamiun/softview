<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingPropertyDetails extends Model
{
    use HasFactory;

    protected $fillable = ['master_id', 'project_id', 'floor_no','floor_type', 
        'total_suite', 'total_unit', 'total_mechanical_room','total_administrative_room',
        'total_amenity_room', 'total_service_room', 'total_parking_lot','total_bike_lot', 
        'total_storage_lot','total_mailroom', 'total_common_area','total_patio', 
         'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

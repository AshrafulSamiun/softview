<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingLot extends Model
{
    protected $fillable = [ 'project_id', 'company_name','customer_name', 'building_name','floor_no', 'property_name',
    'system_prefix','system_no','lot_number','lot_uom','parking_lot_size_qty','total_parking_level_size',
    'total_parking_stall_size','inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

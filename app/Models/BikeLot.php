<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeLot extends Model
{
    use HasFactory;

    protected $fillable = [ 'project_id', 'company_name','strata_lot_no','posting_status', 'building_name','floor_no', 'property_name',
    'system_prefix','system_no','lot_number','lot_uom','bike_lot_size_qty','total_bike_level_size',
    'total_bike_stall_size','inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingInfo extends Model
{
    use HasFactory;

    protected $fillable = ['company_name', 'project_id', 'system_prefix',
    'building_name', 'building_no','strata_lot_no','posting_status', 'number_of_floor','number_of_roof_top','number_of_upper_floor',
    'number_of_ground_floor', 'number_of_under_ground', 'dependent_building','independent_building',
    'residential', 'commercial', 'residential_commercial', 'building_uom','total_building_size',
    'inserted_by', 'updated_by', 'status_active', 'is_deleted'];

}

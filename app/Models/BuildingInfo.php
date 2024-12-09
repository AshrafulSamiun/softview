<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class buildingInfo extends Model
{
        protected $fillable = ['company_name', 'project_id', 'customer_name','system_prefix', 
        'building_name', 'building_no', 'number_of_floor','number_of_roof_top','number_of_upper_floor',
        'number_of_ground_floor', 'number_of_under_ground', 'dependent_building','independent_building',
        'residential', 'commercial', 'residential_commercial', 'building_uom','total_building_size',
        'inserted_by', 'updated_by', 'status_active', 'is_deleted'];

   
}

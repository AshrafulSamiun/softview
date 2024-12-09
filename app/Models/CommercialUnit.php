<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommercialUnit extends Model
{
    protected $fillable = ['property_name', 'project_id', 'company_name','customer_name', 'building_name','floor_no', 'unit_no'
     				,'total_unit_size', 'unit_uom','system_prefix','system_no','unit_type','inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

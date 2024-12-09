<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommonArea extends Model
{
    protected $fillable = [ 'project_id', 'company_name','customer_name', 'building_name','floor_no', 'property_name','system_prefix','system_no','single_subroom_uom','total_size_qty','inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

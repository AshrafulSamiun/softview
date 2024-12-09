<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportingRoom extends Model
{
    protected $fillable = [ 'project_id', 'company_name','customer_name', 'building_name','floor_no',
     				'system_prefix','system_no','inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

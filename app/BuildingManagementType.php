<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BuildingManagementType extends Model
{
    protected $fillable = ['master_id', 'project_id', 'reference_id','item_name', 
        'id_no', 'name', 'phone','website','mobile', 'email','page_id', 
         'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

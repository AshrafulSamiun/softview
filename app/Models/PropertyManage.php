<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyManage extends Model
{
    protected $fillable = ['id', 'project_id', 'moduleId', 'rootMenu', 'position', 'slno', 'user_id', 'property_manage_name', 'inserted_by', 'updated_by', 'status_active', 'is_deleted']; 
	 
}

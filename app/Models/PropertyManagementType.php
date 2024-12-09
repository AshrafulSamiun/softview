<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyManagementType extends Model
{
    protected $fillable = ['security_guard', 'project_id', 'concierge', 'concierge_security', 'artimis', 'property_management', 
     'inserted_by', 'updated_by', 'status_active', 'is_deleted'];

}

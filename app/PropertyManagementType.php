<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyManagementType extends Model
{
    protected $fillable = ['strata_management', 'project_id', 'leasehold_management', 
    'free_hold_management', 'coop_property', 'property_management', 
     'inserted_by', 'updated_by', 'status_active', 'is_deleted'];

}

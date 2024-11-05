<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyProjectLocation extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'project_id', 'building_id', 'master_id', 'floor_id','floor_type', 'prop_master_id',
    	'prop_details_id','inserted_by', 'updated_by', 'status_active', 'is_deleted']; 
}

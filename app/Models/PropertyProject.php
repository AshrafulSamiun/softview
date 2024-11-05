<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyProject extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'project_id', 'master_id', 'system_no', 'system_prefix','project_name','subject_title',
     'current_status','building_type', 'building_id', 'contractor_id_no','contractor_id', 'inserted_by', 'updated_by',
      'status_active', 'is_deleted']; 
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAttributionDetails extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'project_id', 'master_id', 'property_type', 'property_id', 
   'allocated_size', 'inserted_by', 'updated_by', 'status_active', 'is_deleted']; 
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropPrjIncidentReport extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'project_id', 'details', 'reported_by', 'incident_date', 'sl',
    	'inserted_by', 'updated_by', 'status_active', 'is_deleted']; 
}

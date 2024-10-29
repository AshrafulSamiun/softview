<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropPrjIncidentReport extends Model
{
    protected $fillable = ['id', 'project_id', 'details', 'reported_by', 'incident_date', 'sl',
    	'inserted_by', 'updated_by', 'status_active', 'is_deleted']; 
}

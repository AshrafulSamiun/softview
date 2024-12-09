<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class calendarReminder extends Model
{
    protected $fillable = [ 'project_id', 'mst_id', 'job_site_id',
     'company_type','company_id','reminder_no','reminder_period', 'time', 'email','description','inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

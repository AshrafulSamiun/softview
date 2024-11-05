<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyProjectTimeline extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'project_id', 'task_details', 'from_date', 'to_date','hours', 'days', 'task_status',
    	'resedule_from_date1','resedule_to_date1','resedule_from_date2','resedule_to_date2','resedule_from_date3',
    	'resedule_to_date3','due_date','is_callender','inserted_by', 'updated_by', 'status_active', 'is_deleted']; 

}

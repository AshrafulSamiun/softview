<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'project_id','company_id','system_no','system_prefix','issue_date','issued_by','priority', 'status',  'rejection_cause', 'expire_date','job_site','subject','details','dedline_date', 'required_action', 'instruction', 'posting_status','archived',  'inserted_by','updated_by','status_active','is_deleted'
    ];
}

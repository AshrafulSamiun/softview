<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPrivilegeMaster extends Model
{
    protected $fillable = [
        'project_id', 'job_site_id','company_id', 'company_type','system_prefix','system_no', 'user_type','user_role','user_id','expire_date','expire_time','posting_status','status_active','is_deleted','inserted_by','updated_by'
      ];

     public $timestamps = true;

    public function jobSite()
    {
        return $this->belongsTo('App\JobSite','job_site_id', 'id');
    }
    public function User()
    {
        return $this->belongsTo('App\User','user_id', 'id');
    }
}

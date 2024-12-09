<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSite extends Model
{
    protected $fillable = [ 
    'project_id','system_no','system_prefix','current_status','site_name','site_type','company_id','company_type','inserted_by','updated_by','status_active','is_deleted','posting_status'
    ]; 

    public function customer()
    {
        return $this->belongsTo('App\AccountHolderCustomer','company_id', 'id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class inseuranceType extends Model
{
    protected $fillable = ['id', 'project_id', 'reference_id', 'item_name', 'company_name', 'address', 'policy_no', 
    'expire_date','max_coverage', 'inserted_by', 'updated_by', 'status_active', 'is_deleted']; 

}

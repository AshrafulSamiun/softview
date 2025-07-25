<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserServicePlanDetails extends Model
{
     protected $fillable = ['master_id', 'project_id', 'plan_id','rate_applicable','subgroup_id',
    'service_anable','quantity','rate','amount', 'discount_amount','inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

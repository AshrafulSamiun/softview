<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserServicePlan extends Model
{
    use HasFactory;

    protected $fillable = ['management_type', 'project_id', 'is_monthly',
    'total_monthly_amount', 'total_yearly_net_amount', 'total_discount_amount', 'total_yearly_amount', 
      'inserted_by', 'updated_by', 'status_active', 'is_deleted'];

}

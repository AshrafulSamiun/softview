<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InseuranceType extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'project_id', 'reference_id', 'item_name', 'company_name', 'address', 'policy_no', 
    'expire_date','max_coverage', 'inserted_by', 'updated_by', 'status_active', 'is_deleted']; 

}

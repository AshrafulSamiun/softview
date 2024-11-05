<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialInfoType extends Model
{ 
    protected $fillable = [ 
        'project_id','moduleId','position','slno','user_id','financial_info_name','inserted_by','updated_by','status_active','is_deleted', 
    ]; 
}

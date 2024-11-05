<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialInfoDetail extends Model
{
 
    protected $fillable = [ 
        'project_id','user_id','mst_id','reference_id','user_id','financial_info_name','currency','amount','payment_due_date','comment','inserted_by','updated_by','status_active','is_deleted', 
    ]; 
}

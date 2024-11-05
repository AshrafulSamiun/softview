<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoaGroup extends Model
{
     protected $fillable = [
        'project_id','reference_id', 'main_level', 'sub_level','third_level','forth_level','account_title','active','statement_type','balance_sheet','income_statement','retained_earning','transaction_type','balance_type','inserted_by','updated_by','status_active','is_deleted'
    ];
}

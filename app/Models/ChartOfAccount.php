<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartOfAccount extends Model
{
    protected $fillable = [
        'project_id', 'coa_group','sub_group','second_level','third_level','forth_level', 'account_no','description','govt_tax_code','tax_code','inserted_by','updated_by','status_active','is_deleted'
    ];
}

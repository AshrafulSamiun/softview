<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyGovernmentAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'page_id','master_id','reference_id', 'reference_value','account_number','filling_date', 'filling_cycle',
        'is_callender','inserted_by','updated_by','status_active','is_deleted'
    ];
}

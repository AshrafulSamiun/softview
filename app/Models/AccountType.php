<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'account_type','chart_of_account','page_id', 'chart_of_account_id','inserted_by','updated_by','status_active','is_deleted'
    ];
}

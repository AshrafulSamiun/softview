<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountHolderSuffix extends Model
{
    protected $fillable = [
        'project_id', 'suffix','prifix','company_id','user_type','inserted_by','updated_by','status_active','is_deleted'
    ];
}

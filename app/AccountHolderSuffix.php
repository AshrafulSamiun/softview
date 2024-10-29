<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountHolderSuffix extends Model
{
    protected $fillable = [
        'project_id', 'suffix','prifix','user_type','inserted_by','updated_by','status_active','is_deleted'
    ];
}

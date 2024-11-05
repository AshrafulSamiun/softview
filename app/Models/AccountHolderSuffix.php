<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountHolderSuffix extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'suffix','prifix','user_type','inserted_by','updated_by','status_active','is_deleted'
    ];
}

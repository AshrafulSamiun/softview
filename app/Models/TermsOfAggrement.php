<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermsOfAggrement extends Model
{
    use HasFactory;

    protected $fillable = [
        'diclaration', 'full_name','position','office_phone','mobile',
        'email', 'location',
        'project_id', 'inserted_by','updated_by','status_active','is_deleted'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class keyPositionLavel extends Model
{
    protected $fillable = [
        'project_id', 'page_id','field_name','inserted_by','updated_by','status_active','is_deleted'
    ];
}

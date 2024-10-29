<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class taxTypeInitial extends Model
{
    protected $fillable = [
        'project_id', 'type','field_name','inserted_by','updated_by','status_active','is_deleted'
    ];
}

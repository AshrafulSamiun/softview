<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class industrySector extends Model
{
    protected $fillable = [
        'project_id', 'sector_name','inserted_by','updated_by','status_active','is_deleted'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class governmentAccountLavel extends Model
{
    protected $fillable = [
        'project_id', 'page_id','field_name','inserted_by','updated_by','status_active','is_deleted'
    ];
}

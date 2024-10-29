<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class coa_group_initiall extends Model
{
    protected $fillable = [
        'project_id', 'main_level', 'sub_level','third_level','forth_level','level_name','inserted_by','updated_by','status_active','is_deleted'
    ];
}

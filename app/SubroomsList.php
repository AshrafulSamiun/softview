<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubroomsList extends Model
{
    protected $fillable = [
        'project_id',  'item_name', 'item_type','serial_no','inserted_by','updated_by','status_active','is_deleted'
    ];
}

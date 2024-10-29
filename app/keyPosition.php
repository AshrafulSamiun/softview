<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class keyPosition extends Model
{
    protected $fillable = [
        'project_id', 'page_id','master_id','reference_id', 'reference_value','office_phone','office_mobile', 'fax','email',
        'key_position_name','inserted_by','updated_by','status_active','is_deleted'
    ];
}

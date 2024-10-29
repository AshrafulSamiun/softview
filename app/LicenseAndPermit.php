<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LicenseAndPermit extends Model
{
    protected $fillable = [
        'project_id', 'page_id','item_name','item_type','inserted_by','updated_by','status_active','is_deleted'
    ];
}

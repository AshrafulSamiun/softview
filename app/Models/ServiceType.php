<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = [
        'project_id', 'service_name','inserted_by','updated_by','status_active','is_deleted'
    ];
}

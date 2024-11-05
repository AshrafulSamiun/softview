<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageStallDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id','master_id','details_id','item_id','system_no','',  'item_name',
        'comments','status', 'inserted_by','updated_by','status_active','is_deleted'
    ];
}

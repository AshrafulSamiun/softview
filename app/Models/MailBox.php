<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailBox extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id','master_id','details_id','item_id','system_prefix','system_no','uom', 'item_size','allocated', 'item_name','property_name','comments', 'inserted_by','updated_by','status_active','is_deleted'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubroomsList extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',  'item_name', 'item_type','serial_no','inserted_by','updated_by','status_active','is_deleted'
    ];
}

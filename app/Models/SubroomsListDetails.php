<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubroomsListDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id','master_id','property_no','item_id', 'item_qty',  'item_name', 'item_type','inserted_by','updated_by','status_active','is_deleted'
    ];
}

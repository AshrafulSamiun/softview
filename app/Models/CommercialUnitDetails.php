<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommercialUnitDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id','master_id','details_id','item_id','uom', 'item_size',  'item_name', 'inserted_by','updated_by','status_active','is_deleted'
    ];
}

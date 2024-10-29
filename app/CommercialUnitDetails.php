<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommercialUnitDetails extends Model
{
    protected $fillable = [
        'project_id','master_id','details_id','item_id','uom', 'item_size',  'item_name', 'inserted_by','updated_by','status_active','is_deleted'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertCenterItem extends Model
{
    protected $fillable = ['project_id', 'page_id', 'root_id','item_name','header','position','inserted_by', 'updated_by', 'status_active', 'is_deleted']; 
}

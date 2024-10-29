<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyProjectAmount extends Model
{
    protected $fillable = ['id', 'project_id', 'type', 'title', 'amount_before_tax','taxes', 'sl',
    	'inserted_by', 'updated_by', 'status_active', 'is_deleted']; 
}

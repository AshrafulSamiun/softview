<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyProjectAmount extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'project_id', 'type', 'title', 'amount_before_tax','taxes', 'sl',
    	'inserted_by', 'updated_by', 'status_active', 'is_deleted']; 
}

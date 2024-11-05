<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomFieldData extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','page_id','master_id','field_type','field_id','text','number','date_time',
    'inserted_by','updated_by','status_active','is_deleted'];
}

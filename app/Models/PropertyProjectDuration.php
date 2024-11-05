<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyProjectDuration extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'project_id', 'item_name', 'from_date', 'to_date', 'net_year', 'net_days','inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TowerInspectionList extends Model
{
    use HasFactory;

    protected $fillable = ['room_name', 'project_id', 'inspection_task','frequench_check','inspection_by','send_report_to',  'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

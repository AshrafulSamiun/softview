<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;

    protected $fillable = ['floor_name', 'project_id', 'company_name', 'building_name', 'floor_no', 'system_prefix','system_no','strata_lot_no','posting_status',
    		'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

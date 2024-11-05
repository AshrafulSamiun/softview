<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportingRoom extends Model
{
    use HasFactory;

    protected $fillable = [ 'project_id', 'company_name','posting_status','strata_lot_no', 'building_name','floor_no','system_prefix', 'system_no', 'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

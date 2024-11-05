<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageLot extends Model
{
    use HasFactory;

    protected $fillable = [ 'project_id', 'company_name','strata_lot_no', 'building_name','floor_no', 'property_name', 'posting_status', 
    'system_prefix','system_no','lot_number','lot_uom','storage_lot_size_qty','total_storage_level_size',
    'total_storage_stall_size','inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

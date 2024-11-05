<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResidentialSuite extends Model
{
    use HasFactory;

    protected $fillable = ['property_name', 'project_id', 'company_name','strata_lot_no','posting_status', 'building_name', 'floor_no','system_prefix','system_no','suite_no','suite_type', 'suite_uom','total_suite_size', 'inserted_by', 'updated_by', 'status_active', 'is_deleted'];

    public function floor()
	{
		return $this->belongsTo('App\Models\Floor','floor_no', 'id');
	}
}

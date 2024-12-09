<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResidentialSuite extends Model
{
    protected $fillable = ['property_name', 'project_id', 'company_name','customer_name', 'building_name', 'floor_no',
     				'system_prefix','system_no','suite_no','suite_type','suite_uom','total_suite_size',
    				'inserted_by', 'updated_by', 'status_active', 'is_deleted'];

    public function floor()
	{
		return $this->belongsTo('App\Floor','floor_no', 'id');
	}
}

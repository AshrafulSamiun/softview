<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UomSetting extends Model
{
	protected $fillable = ['id', 'project_id', 'company_name', 'uom', 'inserted_by', 'updated_by', 'status_active', 'is_deleted']; 

}

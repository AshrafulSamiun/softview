<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedAsset extends Model
{
    use HasFactory;

    protected $fillable = [ 'project_id', 'asset_category','sub_category',  'inserted_by', 'updated_by', 'status_active', 'is_deleted','system_prefix',
		 'system_no',  'asset_name', 'serial_no', 'uom', 'condition','model','color', 'barcode','comments','length_uom', 'item_length', 
		  'width_uom','item_width', 'height_uom', 'item_height', 
	];
}

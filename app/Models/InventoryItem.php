<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $fillable = [ 'project_id', 'item_category',  'inserted_by', 'updated_by', 'status_active', 'is_deleted','system_prefix',
    		 'system_no',  'item_name', 'item_description', 'uom', 'condition','model', 'storage_requirement','negative_quantity',
    		 'negative_amount', 'minimum_quantity', 'maxmum_quantity','length_uom', 'item_length',  'width_uom','item_width', 
    		 'height_uom', 'item_height', 'sales_tax',  'purchase_tax', 'active', 'chart_of_account', 'chart_of_account_id'
    	];

}

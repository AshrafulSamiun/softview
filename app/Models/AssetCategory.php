<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetCategory extends Model
{
    protected $fillable = [
        'project_id', 'item_name','root_item','sub_root_item','inserted_by','updated_by','status_active','is_deleted'
    ];
}

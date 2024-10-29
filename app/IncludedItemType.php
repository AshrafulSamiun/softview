<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncludedItemType extends Model
{
     protected $fillable = ['id', 'project_id', 'moduleId', 'rootMenu', 'position', 'slno', 'user_id', 'included_item_name', 'inserted_by', 'updated_by', 'status_active', 'is_deleted']; 
}

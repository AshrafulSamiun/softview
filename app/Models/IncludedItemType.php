<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncludedItemType extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'project_id', 'moduleId', 'rootMenu', 'position', 'slno', 'user_id', 'included_item_name', 'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

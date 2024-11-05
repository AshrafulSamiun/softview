<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousingPropertyManage extends Model
{
    use HasFactory;

	protected $fillable = ['id', 'project_id', 'user_id', 'mst_id', 'page_id','reference_id','property_manage_by_name','id_no','cantact','yes_no', 'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

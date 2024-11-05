<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingContactDetails extends Model
{
    use HasFactory;

    protected $fillable = ['master_id', 'project_id','page_id', 'reference_id','item_id','item_name', 
        'contact_no', 'comment', 'phone','website','mobile', 'email', 'hours_of_operation',  
         'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

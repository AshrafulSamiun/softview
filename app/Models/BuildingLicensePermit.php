<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingLicensePermit extends Model
{
    use HasFactory;

    protected $fillable = ['master_id', 'project_id', 'reference_id','item_name', 
        'issued_by', 'expiry_date', 'phone','website','mobile', 'email', 'comment',
         'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

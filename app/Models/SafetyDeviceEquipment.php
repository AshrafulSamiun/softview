<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafetyDeviceEquipment extends Model
{
    use HasFactory;

    protected $table = 'safety_device_equipments';

    protected $fillable = ['master_id', 'project_id','page_id', 'reference_id','item_id',
        'reference_name', 'name','comments','floor_no','serial_no', 'expiry_date', 'renew_date',
        'due_on','cicle', 'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

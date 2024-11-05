<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginInfo extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'user_id', 'ip_address','device_name', 'country_code', 'country_name', 'city_name','region_code','region_name', 'zip_code', 'time_zone', 'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

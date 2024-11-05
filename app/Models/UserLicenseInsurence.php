<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLicenseInsurence extends Model
{
    use HasFactory;

     protected $fillable = [
        'project_id', 'user_id', 'permit_start','permit_end','permit_expire_date','permit_image_id','license_start','license_end','license_expire_date','license_image_id','liability_start','liability_end','liability_expire_date','liability_image_id',
        'home_insurence_start', 'home_insurence_end', 'home_insurence_expire_date','home_insurence_image_id','car_insurence_start','car_insurence_end','car_insurence_expire_date','car_insurence_image_id','inserted_by','updated_by','status_active','is_deleted',
    ];
}

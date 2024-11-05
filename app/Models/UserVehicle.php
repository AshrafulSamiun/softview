<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVehicle extends Model
{
    use HasFactory;

     protected $fillable = [
        'project_id', 'user_id', 'vihicle_model_no','vihicle_model_year','vihicle_color','vihicle_plate_no','vihicle_ins_exp_date','inserted_by','updated_by','status_active','is_deleted',
    ];
}

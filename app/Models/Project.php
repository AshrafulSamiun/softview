<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_status', 'project_name','property_code','package_name','package_id','project_status',
        'activation_status', 'package_status',
    ];
}

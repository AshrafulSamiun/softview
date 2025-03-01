<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
   protected $fillable = [
        'project_status', 'project_name','property_code','package_name','package_id','project_status','master_company_code','activation_status', 'package_status',
   ];
}

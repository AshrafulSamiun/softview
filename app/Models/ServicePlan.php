<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePlan extends Model
{
    use HasFactory;

    protected $fillable = ['plan_name', 'management_type', 'type_of_service','rate',
    'amount', 'rate_applicable', 'status', 'slno'];

}

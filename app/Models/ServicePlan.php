<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class servicePlan extends Model
{
    protected $fillable = ['plan_name', 'management_type', 'type_of_service','rate',
    'amount', 'rate_applicable', 'status', 'slno'];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'system_prefix', 'system_no', 'service_title','service_description','service_category', 'service_type',
        'purchase_tax','sales_tax', 'service_cost','inserted_by','updated_by','status_active','is_deleted'
    ];
}

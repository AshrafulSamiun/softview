<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_phone', 'service_contact_date','service_request_start_date','duration','charging_peroid',
        'amount_before_tax', 'currency','business_term','charging_date','late_payment',
        'reconnection_service_fee', 'reconnection_date','nsf_fee',
        'project_id', 'inserted_by','updated_by','status_active','is_deleted'
    ];
}

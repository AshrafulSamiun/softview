<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class service_contact extends Model
{
    protected $fillable = [
        'contact_phone', 'service_contact_date','service_start_date','service_end_date','reconnection_period', 'duration', 
        'charging_peroid','amount_before_tax', 'currency','business_term','charging_date','late_payment','reconnection_service_fee', 'reconnection_date',
        'nsf_fee','payment_method', 'project_id', 'inserted_by','updated_by','status_active','is_deleted'
    ];
}

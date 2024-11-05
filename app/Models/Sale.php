<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

     protected $fillable = ['project_id','company_id','company_type','entry_form','unique_no','system_prefix','transaction_no','purchase_type','seller_id','seller_id','seller_account_no',
    'service_provider_account_no','service_provider_id','customer_id','customer_account_no','schedule_delivery_date','delivery_location',
    'delivery_instruction','delivery_contact_person_name','delivery_contact_person_email','delivery_contact_person_phone',
    'delivery_receive_by','payment_due_date','days_left_to_pay','early_payment_discount','payment_method','posted_check_available',
    'late_payment_pelanty','hidden_cost','shipping_cost_pay_by','payment_status','shipping_company_id','shipping_company_account_no','notification_by',
    'backorder_allowed','approval_status','posting_status','vehicle_identification_number','vehicle_make','vehicle_model','vehicle_year','vehicle_type',
    'vehicle_license_plate','vehicle_image_id','vehicle_insurance_information','driver_id','driver_address','driver_name',
    'driver_license_no','driver_contact_no','next_step_return','next_step_debit','next_step_credit','next_step','inserted_by','updated_by','status_active','is_deleted'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['page_id', 'project_id', 'system_prefix','system_no', 'account_no', 'scope_of_operation',
     'customer_type','company_id','account_status', 'status_date', 'acount_reason','account_comments','legal_name',
     'operational_name', 'headoffice_house_number', 'headoffice_street_number','headoffice_city', 'headoffice_state', 'headoffice_country',
     'headoffice_zip_code','currency_domestic','foreign_corrency_1', 'foreign_corrency_2', 'foreign_corrency_3','foreign_corrency_4', 
     'foreign_corrency_5', 'invoice_term', 'sales_tax','credit_limit_daily', 'credit_limit_weekly', 'credit_limit_monthly',
     'credit_limit_semi_monthly','credit_limit_yearly','fiscal_year_start_date', 'fiscal_year_end_date', 'fiscal_year_in_calender','recuring_cycle', 
     'sales_on_credit', 'sales_return', 'invoice_pay_off_order_oldest','invoice_pay_off_order_newest', 'invoice_pay_off_order_optional', 'accepted_payment_method_cash',
     'accepted_payment_method_check','accepted_payment_method_credit_card','accepted_payment_method_pap', 'accepted_payment_method_dd', 'accepted_payment_method_email', 
     'invoice_delivery_method_hard_copy', 'invoice_delivery_method_email', 'invoice_delivery_method_both','calendr_director', 'calender_accounting_manager', 'calender_building_manager',
     'calender_general_manager','calender_netwrok_administrator','calender_property_manager', 'calender_account_payable', 'comment_calendar','comment_date',  
         'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

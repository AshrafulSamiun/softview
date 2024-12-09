<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountHolderServiceProvider extends Model
{
    protected $fillable = ['project_id','company_id','posting_status', 'system_prefix', 'system_no','account_type','service_provider_name','service_provider_photo','service_provider_office_phone','service_provider_cell_phone','service_provider_email','service_provider_fax_no','service_provider_website', 'service_provider_house_number', 'service_provider_street_number','service_provider_city', 'service_provider_state','service_provider_country','service_provider_zip_code', 'company_name', 'company_logo', 'industry_sector','company_house_number','company_street_number','company_city','company_state','company_country','company_zip_code','company_office_phone','company_cell_phone','company_email','company_fax_no','company_website','payment_method','invoice_term','credit_limit','chart_of_acocounts','account_creation_date','acount_status','professional_license_associate_name', 'professional_license_title', 'professional_license_house_number', 'professional_license_street_number','professional_license_city',  'professional_license_state', 'professional_license_country','professional_license_zip_code','professional_license_email', 'professional_license_fax_no', 'professional_office_phone','professional_license_cell_phone','professional_license_website','professional_license_no','professional_license_expire_date','professional_license_renewal_date','professional_license_validation_status','comments','inserted_by', 'updated_by', 'status_active', 'is_deleted']; 
}

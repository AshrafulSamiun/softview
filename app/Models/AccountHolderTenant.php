<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountHolderTenant extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'system_prefix', 'system_no','account_type','tenant_name','tenant_photo','tenant_office_phone','tenant_cell_phone','tenant_email','tenant_fax_no','tenant_website', 'tenant_house_number', 'tenant_street_number','tenant_city', 'tenant_state','tenant_country','tenant_zip_code', 'company_name', 'company_logo', 'industry_sector','company_house_number','company_street_number','company_city','company_state','company_country','company_zip_code','company_office_phone','company_cell_phone','company_email','company_fax_no','company_website','payment_method','invoice_term','credit_limit','chart_of_acocounts','account_creation_date','acount_status','property_management_company_name', 'property_management_manager_name', 'property_management_logo', 'property_management_house_number', 'property_management_street_number','property_management_city',  'property_management_state', 'property_management_country','property_management_zip_code','property_management_email', 'property_management_fax_no', 'property_management_office_phone','property_management_cell_phone','company_id','property_management_website','comments','inserted_by', 'updated_by', 'status_active', 'is_deleted','account_holder_portal','account_holder_dedicated_file','account_holder_title_name','service_type','emergency_contact_company_name','emergency_contact_house_number', 'emergency_contact_street_number','emergency_contact_city','emergency_contact_state', 'emergency_contact_country','emergency_contact_zip_code','emergency_contact_email', 'emergency_contact_fax_no', 'emergency_contact_office_phone','emergency_contact_cell_phone','emergency_contact_website','emergency_photo','emergency_relationship','emergency_gender']; 
}

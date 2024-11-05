<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountHolderLeaseholder extends Model
{
    protected $fillable = ['project_id', 'system_prefix', 'system_no','account_type','lease_holder_name','lease_holder_photo','lease_holder_office_phone','lease_holder_cell_phone','lease_holder_email','lease_holder_fax_no','lease_holder_website', 'lease_holder_house_number', 'lease_holder_street_number','lease_holder_city', 'lease_holder_state','lease_holder_country','lease_holder_zip_code', 'company_name', 'company_logo', 'industry_sector','company_house_number','company_street_number','company_city','company_state','company_country','company_zip_code','company_office_phone','company_cell_phone','company_email','company_fax_no','company_website','payment_method','invoice_term','credit_limit','chart_of_acocounts','account_creation_date','acount_status','property_management_company_name', 'property_management_manager_name', 'property_management_logo', 'property_management_house_number','company_id', 'property_management_street_number','property_management_city',  'property_management_state', 'property_management_country','property_management_zip_code','property_management_email', 'property_management_fax_no', 'property_management_office_phone','property_management_cell_phone','property_management_website','comments','inserted_by', 'updated_by', 'status_active', 'is_deleted','account_holder_portal','account_holder_dedicated_file','account_holder_title_name']; 
}

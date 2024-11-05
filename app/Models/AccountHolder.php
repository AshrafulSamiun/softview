<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountHolder extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'system_prefix', 'system_no','account_type',  'entity_type', 'first_name', 'middle_name','last_name','industry_sector',
    	 'reg_cor_dir_info', 'register_corp_first_name','register_corp_middle_name','register_corp_last_name', 'register_corp_phone_no', 'register_corp_email',
    	'register_emergency_contact','house_number', 'street_number', 'city','state', 'country','zip_code','email', 'fax_no', 'cell_phone', 'website', 
    	'business_license_issued_by', 'business_license_house_number', 'business_license_street_number','business_license_city',  'business_license_state', 'business_license_country',
    	'business_license_zip_code','business_license_email', 'business_license_fax_no', 'business_license_cell_phone','business_license_website','business_license_no', 
    	'business_license_issue_date', 'business_license_expire_date','business_license_is_callender','business_license_validation_status', 
    	'professional_license_associate_name', 'professional_license_house_number', 'professional_license_street_number','professional_license_city',  'professional_license_state', 'professional_license_country',
    	'professional_license_zip_code','professional_license_email', 'professional_license_fax_no', 'professional_license_cell_phone','professional_license_website','professional_license_no', 
    	'professional_license_issue_date', 'professional_license_expire_date','professional_license_is_callender','professional_license_validation_status', 
    	'liabilities_insurence_issued_by', 'liabilities_insurence_house_number', 'liabilities_insurence_street_number','liabilities_insurence_city',  'liabilities_insurence_state', 'liabilities_insurence_country', 
    	'liabilities_insurence_zip_code','liabilities_insurence_email', 'liabilities_insurence_fax_no', 'liabilities_insurence_cell_phone','liabilities_insurence_website','liabilities_insurence_no', 
    	'liabilities_insurence_issue_date', 'liabilities_insurence_expire_date','liabilities_insurence_is_callender','liabilities_insurence_validation_status',  
    	'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

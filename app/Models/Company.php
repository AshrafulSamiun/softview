<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['account_no','project_id','account_prefix','scope_of_operation','legal_name','business_registration_number',
                    'registration_date','business_registration_city','business_registration_state','registration_country',
                    'business_license_no','issued_by','license_state','license_country','expirey_date','headoffice_house_number',
                    'headoffice_street_number','headoffice_city','headoffice_state','headoffice_country','headoffice_zip_code',
                    'contact_person_email','contact_person_fax_no','contact_person_cell_phone','contact_person_website',
                    'strata_management','parking_management_industry','storage_management_company','leasehold_management',
                    'property_management','calender_property_manager','calender_general_manager','calender_building_manager',
                    'calender_accounts_payable','calender_accounting_manager','calender_director','calender_network_administrator',
                    'customer_property_management','customer_seller','customer_service_provider','fiscal_year_start_date',
                    'fiscal_year_end_date','fiscal_year_in_calender',
                    'recuring_cycle','comment_in_calender','comments','comment_date',
                    'inserted_by','updated_by','status_active','is_deleted'];

     
}

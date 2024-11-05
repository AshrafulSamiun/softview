<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'user_id', 'strata_management','company_logo_id','coop_property','free_hold_management',
        'leasehold_management','property_management','type_of_operation','management_type',
        'legal_name', 'business_registration_number', 'registration_date','business_registration_city',
        'business_registration_state','registration_country',
        'business_license_no','issued_by','license_state','license_country', 'expirey_date',
         'headoffice_street_number', 'headoffice_city','headoffice_state','headoffice_country',
        'contact_person_email','contact_person_fax_no','contact_person_cell_phone', 'contact_person_website',
        'business_number','emp_identification_number','payroll','sales_tax', 'income_tax','import_and_export','dependent_residential_suite',
        'dependent_residental_parking_lot','dependent_residental_storage_lot', 'dependent_commercial_unit',
         'dependent_commercial_parking_lot','dependent_commercial_storage_lot', 'independent_residential_suite',
         'independent_residental_parking_lot','independent_residental_storage_lot', 'independent_commercial_unit', 
         'independent_commercial_parking_lot','independent_commercial_storage_lot', 'rantal_suite_unit','buy_and_sell_suite_unit',
         'rental_parking', 'rental_storage','landholders_residency', 'inserted_by','updated_by','status_active','is_deleted',

    ];
}

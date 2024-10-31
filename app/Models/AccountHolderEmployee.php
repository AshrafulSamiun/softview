<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountHolderEmployee extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'system_prefix', 'system_no','account_type','employee_name','employee_photo',
        'employee_office_phone','employee_cell_phone','employee_email','employee_fax_no','employee_website',
        'employee_house_number', 'employee_street_number','employee_city', 'employee_state','employee_country',
        'employee_zip_code', 'company_name', 'company_logo', 'industry_sector','company_house_number','company_street_number',
        'company_city','company_state','company_country','company_zip_code','company_office_phone','company_cell_phone',
        'company_email','company_fax_no','company_website','payment_method','invoice_term','credit_limit','chart_of_acocounts',
        'account_creation_date','acount_status','emergency_contact_company_name','emergency_contact_house_number',
        'emergency_contact_street_number','emergency_contact_city',  'emergency_contact_state', 'emergency_contact_country',
        'emergency_contact_zip_code','emergency_contact_email', 'emergency_contact_fax_no', 'emergency_contact_office_phone',
        'emergency_contact_cell_phone','company_id','emergency_contact_website','comments','inserted_by', 'updated_by',
        'status_active', 'is_deleted','account_holder_portal','account_holder_dedicated_file','account_holder_title_name',
        'emergency_relationship','emergency_gender'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountCompany extends Model
{
    

    protected $fillable = [
        
        'project_id', 'user_id', 'company_logo_id','legal_name', 'business_registration_number', 'city','state','country','zip_code', 'website',
        'management_type','business_registration_city','business_registration_state','business_registration_country','business_registration_zip_code',
        'email','contact_person_name','position_in_company','contact_person_cell_phone','contact_person_email','company_logo_id',
        'license_no','license_issuer','license_date','license_expirey_date',  
        'inserted_by','updated_by','status_active','is_deleted'

    ];
}

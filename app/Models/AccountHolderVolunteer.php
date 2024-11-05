<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountHolderVolunteer extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'system_prefix', 'system_no','account_type','volunteer_name','volunteer_photo','volunteer_office_phone','volunteer_cell_phone','volunteer_email','volunteer_fax_no','volunteer_website', 'volunteer_house_number', 'volunteer_street_number','volunteer_city', 'volunteer_state','volunteer_country','volunteer_zip_code', 'company_name', 'company_logo', 'industry_sector','company_house_number','company_street_number','company_city','company_state','company_country','company_zip_code','company_office_phone','company_cell_phone','company_email','company_fax_no','company_website','payment_method','company_id','invoice_term','department','section','weekly_hours','credit_limit','chart_of_acocounts','account_creation_date','acount_status','comments','inserted_by', 'updated_by', 'status_active', 'is_deleted','account_holder_portal','account_holder_dedicated_file','account_holder_title_name'];
}

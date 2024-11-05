<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountHolderInvestor extends Model
{
    protected $fillable = ['project_id', 'system_prefix', 'system_no','account_type','investor_name','investor_photo','investor_office_phone','investor_cell_phone','investor_email','investor_fax_no','investor_website', 'investor_house_number', 'investor_street_number','investor_city', 'investor_state','investor_country','investor_zip_code', 'company_name', 'company_logo', 'industry_sector','company_house_number','company_street_number','company_city','company_state','company_country','company_zip_code','company_office_phone','company_cell_phone','company_email','company_fax_no','company_website','payment_method','company_id','invoice_term','credit_limit','chart_of_acocounts','account_creation_date','acount_status','comments','inserted_by', 'updated_by', 'status_active', 'is_deleted','account_holder_portal','account_holder_dedicated_file','account_holder_title_name']; 
}

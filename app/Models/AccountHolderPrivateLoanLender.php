<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountHolderPrivateLoanLender extends Model
{
    protected $fillable = ['project_id', 'system_prefix', 'system_no','account_type','privateloanlender_name','privateloanlender_photo','privateloanlender_office_phone','privateloanlender_cell_phone','privateloanlender_email','privateloanlender_fax_no','privateloanlender_website', 'privateloanlender_house_number', 'privateloanlender_street_number','privateloanlender_city', 'privateloanlender_state','privateloanlender_country','privateloanlender_zip_code', 'company_name', 'company_logo', 'industry_sector','company_house_number','company_street_number','company_city','company_state','company_country','company_zip_code','company_office_phone','company_cell_phone','company_email','company_fax_no','company_website','payment_method','invoice_term','credit_limit','chart_of_acocounts','company_id','account_creation_date','acount_status','comments','inserted_by', 'updated_by', 'status_active', 'is_deleted','account_holder_portal','account_holder_dedicated_file','account_holder_title_name'];
}

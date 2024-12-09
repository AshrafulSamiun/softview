<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountHolderCustomer extends Model
{
    protected $fillable = ['project_id','company_id', 'posting_status','system_prefix', 'system_no','account_type','customer_name','customer_photo','customer_office_phone','customer_cell_phone','customer_email','customer_fax_no','customer_website', 'customer_house_number', 'customer_street_number','customer_city', 'customer_state','customer_country','customer_zip_code', 'company_name', 'company_logo', 'industry_sector','company_house_number','company_street_number','company_city','company_state','company_country','company_zip_code','company_office_phone','company_cell_phone','company_email','company_fax_no','company_website','payment_method','invoice_term','credit_limit','chart_of_acocounts','account_creation_date','acount_status','comments','inserted_by', 'updated_by', 'status_active', 'is_deleted']; 
    
}

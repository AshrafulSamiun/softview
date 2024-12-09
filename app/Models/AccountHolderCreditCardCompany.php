<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountHolderCreditCardCompany extends Model
{
    protected $fillable = ['project_id','company_id','posting_status', 'system_prefix', 'system_no','credit_card_company_name','card_type','payment_due_remainders','credit_limit','account_alert','chart_of_acocounts', 'account_creation_date','acount_status','comments','account_type','house_number', 'street_number', 'city','state', 'country','zip_code','email', 'fax_no', 'cell_phone', 'website','office_phone','inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

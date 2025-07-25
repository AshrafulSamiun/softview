<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
class AccountHolderBank extends Model
{
    protected $fillable = ['project_id','company_id','posting_status', 'system_prefix', 'system_no','bank_acount_no','bank_account_name','branch_name','chart_of_acocounts', 'account_creation_date','acount_status','comments','account_type','house_number', 'street_number', 'city','state', 'country','zip_code','email', 'fax_no', 'cell_phone', 'website','office_phone','inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountHolderCreditCardCompany extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'system_prefix', 'system_no','credit_card_company_name','card_type','payment_due_remainders','credit_limit','account_alert','chart_of_acocounts', 'account_creation_date','acount_status','comments','account_type','house_number', 'street_number', 'city','state', 'country','zip_code','email', 'fax_no', 'cell_phone', 'website','company_id','office_phone','inserted_by', 'updated_by', 'status_active', 'is_deleted','account_holder_portal','account_holder_dedicated_file','account_holder_title_name'];
}

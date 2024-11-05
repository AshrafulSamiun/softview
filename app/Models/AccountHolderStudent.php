<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountHolderStudent extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'system_prefix', 'system_no','client_name','client_type','account_manager_name','chart_of_acocounts', 'account_creation_date','acount_status','comments','account_type','house_number', 'street_number', 'city','state', 'country','zip_code','email','company_id', 'fax_no', 'cell_phone', 'website','office_phone','inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

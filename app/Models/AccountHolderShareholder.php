<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountHolderShareholder extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'system_prefix', 'system_no','share_holder_name','share_holder_position','chart_of_acocounts', 'account_creation_date','acount_status','comments','account_type','house_number', 'street_number', 'city','state', 'country','zip_code','email', 'fax_no', 'cell_phone', 'company_id','website','office_phone','inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountHolderBoardOfDirector extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'system_prefix', 'system_no','board_of_director_name','board_of_director_position','chart_of_acocounts', 'account_creation_date','acount_status','comments','account_type','house_number', 'street_number', 'city','state', 'country','zip_code','email', 'fax_no', 'cell_phone', 'website','office_phone','company_id','bank_account_type','inserted_by', 'updated_by', 'status_active', 'is_deleted' ,'account_holder_portal','account_holder_dedicated_file','board_of_director_name_title','board_of_director_photo','board_of_director_education'];
}

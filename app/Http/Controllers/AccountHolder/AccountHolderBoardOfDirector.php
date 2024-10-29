<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountHolderBoardOfDirector extends Model
{
    protected $fillable = ['project_id', 'system_prefix', 'system_no','board_of_director_name','board_of_director_position','chart_of_acocounts', 'account_creation_date','acount_status','comments','account_type','house_number', 'street_number', 'city','state', 'country','zip_code','email', 'fax_no', 'cell_phone', 'website','office_phone','inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

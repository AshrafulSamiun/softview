<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountHolderBoardOfDirector extends Model
{
    protected $fillable = ['project_id','company_id', 'posting_status','system_prefix', 'system_no','board_of_director_name','board_of_director_position','account_holder_portal','account_holder_dedicated_file','chart_of_acocounts','education','title','photo_id', 'account_creation_date','acount_status','comments','account_type','house_number', 'street_number', 'city','state', 'country','zip_code','email', 'fax_no', 'cell_phone', 'website','office_phone','inserted_by', 'updated_by', 'status_active', 'is_deleted'];

    public function directorphoto()
    {
        return $this->belongsTo('App\Models\FileUpload','photo_id', 'id');
    }

}
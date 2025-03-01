<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountCompany extends Model
{
    

    protected $fillable = [
        
        'project_id', 'user_id', 'company_logo_id','legal_name','headoffice_house_number','headoffice_street_number', 'headoffice_city','headoffice_state','headoffice_country','contact_person_website','contact_person_fax_no','contact_person_cell_phone','contact_person_email','company_logo_id',
        'inserted_by','updated_by','status_active','is_deleted'

    ];

    public function companylogo()
    {
        return $this->belongsTo('App\Models\FileUpload','company_logo_id', 'id');
    }
}

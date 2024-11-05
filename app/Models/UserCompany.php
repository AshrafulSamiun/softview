<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCompany extends Model
{
    use HasFactory;

     protected $fillable = [
        'project_id', 'user_id', 'legal_name','company_logo','website','operational_name',
        'jurisdiction_of_incorporation','incorporation_number',
		'inserted_by','updated_by','status_active','is_deleted',
    ];

    public function companyLogo()
    {
        return $this->belongsTo('App\Models\FileUpload','company_logo', 'id');
    }
}

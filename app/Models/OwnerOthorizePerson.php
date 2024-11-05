<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerOthorizePerson extends Model
{
    use HasFactory;

     protected $fillable = [
        'project_id', 'user_id', 'fm_legal_name','fm_address','fm_photo_id','fm_gove_id_fontpart','fm_gove_id_backpart','relation_with_landlord','fm_office_phone','fm_cell_phone','fm_email','fm_company_name','fm_company_phone','business_address','fm_company_bn_no','fm_company_website','inserted_by','updated_by','status_active','is_deleted',
    ];
}

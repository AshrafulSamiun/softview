<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormEntry extends Model
{
    use HasFactory;

    protected $fillable = ['project_id','company_id','form_type','priority_level','form_no','system_prefix','from_department','purchase_type','seller_id','seller_id','seller_account_no',
    'from_id_name','to_department','to_id_name','subject','posting_status','delivery_location',
    'next_step','inserted_by','updated_by','status_active','is_deleted'];
}

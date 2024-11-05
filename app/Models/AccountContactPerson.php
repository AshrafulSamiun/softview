<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountContactPerson extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name', 'job_title','street_number','city','state',
        'country', 'post_code','po_box','office_phone','mobile',
        'email', 'fax_no','contact_person_id',
        'project_id', 'inserted_by','updated_by','status_active','is_deleted'
    ];
}

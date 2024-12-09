<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountContactPerson extends Model
{
     protected $fillable = [
        'project_id', 'contact_person_name', 'contact_person_departnemt','contact_person_position','contact_person_billing_email','contact_person_support_email','contact_person_office_phone','contact_person_cell_phone','company_id','inserted_by','updated_by','status_active','is_deleted'
    ];
}

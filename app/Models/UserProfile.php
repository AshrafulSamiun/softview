<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'user_id', 'first_name','middle_name','last_name','nick_name','website','office_phone','cell_phone','home_phone','official_email','recovery_email','user_type','user_photo_id', 'country_id', 'billing_country_id','mailing_country_id','state','mailing_state','billing_state','city','mailing_city','billing_city','street','mailing_street','billing_street','postal_code', 'mailing_postal_code', 'billing_postal_code','inserted_by','updated_by','status_active','is_deleted',
    ];
}

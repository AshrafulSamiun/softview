<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailStorage extends Model
{
    protected $fillable = [ 
    'project_id','user_id','massage_body','mail_subject','mail_form','mail_to','mail_cc','mail_date','id_number','name','from_account_type_holder','to_account_type_holder','from_user_type','to_user_type','mail_sent','mail_sending_point','inserted_by','updated_by','status_active','is_deleted',
    ]; 
}

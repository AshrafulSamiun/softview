<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropPrjPaymentSchedule extends Model
{
    protected $fillable = ['id', 'project_id', 'title', 'due_date', 'is_callender','sl','inserted_by', 'updated_by', 'status_active', 'is_deleted']; 

}

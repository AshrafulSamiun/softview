<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalServiceProvider extends Model
{
    protected $fillable = ['master_id', 'project_id','page_id', 'reference_id',
    	'item_name', 'id_no','account_no','website', 'schedule_date', 'expected_due_date','billing_cycle',
         'bill_delivery_method','payment_method', 'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

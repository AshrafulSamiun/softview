<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxType extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'tin_no', 'tax_type','system_prefix','system_no', 'tax_office_name','tax_office_address','tax_office_contact', 'tax_rate','period_name','period_start_date', 'period_end_date','period_due_on','period_add_calendar','inserted_by','updated_by','status_active','is_deleted'
    ];
}

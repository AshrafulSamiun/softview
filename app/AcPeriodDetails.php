<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcPeriodDetails extends Model
{
    protected $fillable = [
        'mst_id','project_id', 'month_id', 'period_starting_date','period_ending_date', 'financial_period', 'is_locked','inserted_by','updated_by','status_active','is_deleted',
        ];
}

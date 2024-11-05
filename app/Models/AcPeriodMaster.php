<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcPeriodMaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_start','project_id','posting_status', 'company_id', 'year_start_date','year_end_date', 'period_name', 'is_current','is_closed','inserted_by','updated_by','status_active','is_deleted',
    ];

    public function periodDetails()
	{
		return $this->hasMany('App\Models\AcPeriodDetails','mst_id', 'id');
	}

	public function company()
	{
		return $this->belongsTo('App\Models\Company','company_id', 'id');
	}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RulesPolicy extends Model
{
    use HasFactory;

    protected $fillable = [ 'project_id', 'system_prefix','system_no', 'rules_policy', 'audience','subject','company_id',
     'issued_date', 'rules_policy_law', 'inserted_by', 'updated_by', 'status_active', 'is_deleted'];

    public function user()
	{
		return $this->belongsTo('App\Models\User', 'inserted_by', 'id');
	}
}

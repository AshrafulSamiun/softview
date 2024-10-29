<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RulesPolicy extends Model
{
    protected $fillable = [ 'project_id', 'system_prefix','system_no', 'rules_policy', 'audience','subject','company_id',
     'issued_date', 'rules_policy_law', 'inserted_by', 'updated_by', 'status_active', 'is_deleted'];

    public function user()
	{
		return $this->belongsTo('App\User', 'inserted_by', 'id');
	}
}

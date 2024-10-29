<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcedureInstruction extends Model
{
    protected $fillable = [ 'project_id', 'system_prefix','system_no', 'procedure_instruction', 'audience','subject','company_id',
     'issued_date', 'procedure_instruction_description', 'inserted_by', 'updated_by', 'status_active', 'is_deleted'];

    public function user()
	{
		return $this->belongsTo('App\User', 'inserted_by', 'id');
	}
}

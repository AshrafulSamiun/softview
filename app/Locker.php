<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    protected $fillable = ['locker_name', 'project_id', 'locker_holder_name','suite_name',  'inserted_by', 'updated_by', 'status_active', 'is_deleted'];

    public function suite()
	{
		return $this->belongsTo('App\Suits','suite_name', 'id');
	}
}

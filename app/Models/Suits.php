<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suits extends Model
{
	    protected $fillable = ['floor_name', 'project_id', 'total_rooms','one_room', 'two_room', 'three_room', 
	'town_house', 'suit_name',  'inserted_by', 'updated_by', 'status_active', 'is_deleted'];


	public function floor()
	{
		return $this->belongsTo('App\Floor','floor_name', 'id');
	}
}

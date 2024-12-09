<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['moduleId', 'rootMenu', 'menuName','menuRoute','class','image', 'status', 'slno', 'project_id'];
   
   	public function module()
	{
		return $this->belongsTo('App\Module','moduleId', 'id');
	}
}

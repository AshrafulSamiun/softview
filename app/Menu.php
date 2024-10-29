<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['moduleId', 'rootMenu', 'menuName','menuRoute', 'status', 'slno', 'project_id'];
   
   	public function module()
	{
		return $this->belongsTo('App\Module','moduleId', 'id');
	}
}

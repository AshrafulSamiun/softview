<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['moduleName', 'modSlNo', 'status','project_id'];
	
	public function menus()
	{
		return $this->hasMany('App\Menu', 'moduleId', 'id');
	}

}

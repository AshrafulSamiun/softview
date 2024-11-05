<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['moduleId', 'rootMenu', 'menuName','menuRoute', 'status', 'slno', 'project_id'];
   
   	public function module()
	{
		return $this->belongsTo('App\Models\Module','moduleId', 'id');
	}
}

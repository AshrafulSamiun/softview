<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    use HasFactory;

    protected $fillable = ['locker_name', 'project_id', 'locker_holder_name','suite_name',  'inserted_by', 'updated_by', 'status_active', 'is_deleted'];

    public function suite()
	{
		return $this->belongsTo('App\Models\Suits','suite_name', 'id');
	}
}

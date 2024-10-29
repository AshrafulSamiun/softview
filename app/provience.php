<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class provience extends Model
{
        protected $fillable = ['provience_name', 'country_id', 'status_active'];
}

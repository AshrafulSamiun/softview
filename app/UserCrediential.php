<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCrediential extends Model
{
    protected $fillable = [
        'user_id', 'user_crediential',
    ];
}

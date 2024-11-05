<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPrivilege extends Model
{
    use HasFactory;

     protected $fillable = [
        'main_menu_id', 'user_id','module_id','project_id', 'show_priv','save_priv','update_priv','delete_priv','approve_priv','status_active','is_deleted','inserted_by','updated_by'
    ];
}

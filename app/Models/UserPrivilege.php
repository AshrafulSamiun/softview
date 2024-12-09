<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPrivilege extends Model
{
   protected $fillable = [

      'main_menu_id','mst_id', 'user_id','project_id', 'show_priv','new_priv','all_priv','save_priv','update_priv','delete_priv','transmit_priv','print_priv','void_priv','post_priv','reject_priv','adjust_priv','repost_priv'
        ,'access_day_from','access_day_to','access_time_start','access_time_end','expire_date', 'status_active','is_deleted','inserted_by','updated_by'
      ];
}

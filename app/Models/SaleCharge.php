<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleCharge extends Model
{
    use HasFactory;

     protected $fillable = [ 'project_id', 'master_id','charge_id', 'charge_type', 'amount',
    				'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

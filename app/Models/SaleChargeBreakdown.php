<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleChargeBreakdown extends Model
{
    protected $fillable = [ 'project_id', 'master_id','detail_id','charge_id', 'charge_type', 'amount',
    				'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

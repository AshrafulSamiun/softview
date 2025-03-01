<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class servicePlan extends Model
{

    protected $table = 'service_plans';

    protected $primaryKey = 'id';

    protected $fillable = [
        'subgroup_id', 
        'plan_type', 
        'amount',
        'qty',
        'rate_applicable',
        'inserted_by',
        'updated_by',
        'status_active',
        'is_deleted',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

}

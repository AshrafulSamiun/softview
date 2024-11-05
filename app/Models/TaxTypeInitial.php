<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxTypeInitial extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'type','field_name','inserted_by','updated_by','status_active','is_deleted'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibSocialLink extends Model
{
    use HasFactory;

    protected $fillable = ['social_name', 'project_id', 'link_name',  'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

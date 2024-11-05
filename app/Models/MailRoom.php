<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailRoom extends Model
{
    use HasFactory;

    protected $fillable = [ 'project_id', 'company_name','strata_lot_no','posting_status', 'building_name','floor_no', 'property_name',
    'system_prefix','system_no','room_no','room_name','room_uom','mailroom_size_qty','total_mailbox_size','inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

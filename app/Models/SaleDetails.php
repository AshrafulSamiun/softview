<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetails extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'project_id', 'master_id', 'item_name', 'product_id', 'item_description', 'qty', 'rate',
    		'addition','addition_percent', 'deduction','deduction_percent', 'sub_total', 'tax_rate','tax', 'total','inserted_by', 'updated_by', 'status_active', 'is_deleted']; 
}

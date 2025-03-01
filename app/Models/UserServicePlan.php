<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserServicePlan extends Model
{
    protected $fillable = ['service_type', 'project_id', 'is_monthly','currency_id','sales_tax_rate', 
    'total_monthly_net_amount','total_sales_tax_monthly','total_monthly_amount', 'total_yearly_net_amount', 
    'total_discount_amount', 'total_sales_tax_yearly', 'total_yearly_amount', 'comments', 
      'inserted_by', 'updated_by', 'status_active', 'is_deleted'];

}

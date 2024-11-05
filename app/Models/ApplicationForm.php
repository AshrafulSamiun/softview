<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationForm extends Model
{
    use HasFactory;

    protected $fillable = ['system_prefix', 'system_no', 'full_name','ba_number',  'rank', 'unit', 'mobile_no',
    	'service_length','plot', 'road', 'current_address','permanent_address','plot', 'road', 'current_address',
    	'permanent_address','nok_name', 'sector', 'city','soil_test', 'soil_test_date', 'structural_design',
    	'tin_no', 'national_id_no', 'bank_account_no', 'required_number_of_piles','depth_of_each_piles','ex_piling_date',
        'inserted_by', 'updated_by', 'status_active', 'is_deleted'];
}

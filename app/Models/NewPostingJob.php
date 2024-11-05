<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewPostingJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_no','project_id','user_id','landlord','leaseholder','tenant','shareholder','servive_provider','seller','guest',
        'visitor','post_user_id','post_name','post_rank','posting_user_type','posting_class','payment_status','posting_status',
        'new_posting_date','renew_posting_date','reported_posting_date','Paid_posting_date','edited_posting_date','validation_period_posting_date',
        'posted_posting_date','expired_posting_date','re_posting_date','publised_posting_date','removing_posting_date', 
        'employer_number','employer_companay_name','full_legal_name','company_address','company_website','company_contacts',
        'company_about_us','posting_title','job_title',' Employment_self_employed','full_part_time','hourly_rate','monthly_salary',
        'posting_benefits','job_description','posting_responsibilities','education_lavel','posting_skills',' job_experience',
        'permit_license','work_location','days_hours','overtime_allowed','probation_period','posting_bondable','contract_requited',
        'medical_test','drug','criminal_check','personal','work','school','living_area','online','phone','in_person','posting_note',
        'posting_accept','inserted_by','updated_by','status_active','is_deleted',  
    ];
}

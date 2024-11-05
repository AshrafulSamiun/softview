<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewPostingHousingRental extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'project_id','user_id','posting_no','posting_prefix','genaral_posting_title','landlord','leaseholder','tenant','shareholder','posting_employee','servive_provider','seller','guest','visitor','post_user_id','post_name','post_rank','posting_user_type','posting_class','payment_status','posting_status','employer_number','company_address','employer_companay_name','company_website','full_legal_name','company_about_us','company_contacts','new_posting_date','renew_posting_date','reported_posting_date','Paid_posting_date','edited_posting_date','validation_period_posting_date','posted_posting_date','expired_posting_date','re_posting_date','publised_posting_date','removing_posting_date','leaseholder_id_number','leaseholder_name','bms_contact_info','building_name','building_address','studio','one_bed','two_bed','three_bed','penthouse','parking_stall','storage_lockers','commercial_unit','map_link','number_of_room','number_of_den','number_of_solarium','number_of_kitchen','number_of_bathroom','number_of_washroom','size_type','number_of_sqft','neighborhood_type','neighborhood_name','neighborhood_address','neighborhood_distance','neighborhood_map_link','allowed_bbq','allowed_smoke','allowed_pet','allowed_max_guest','restrictions_air_bnb','restrictions_sublease','restrictions_max_tenant','restrictions_shared_room','no_music','no_landry_and_washing_machine','pre_authorized_payment','email_transfer','cash','check','credit_card','move_in_out_requirements','availability_date','saturday_schedules_date','sunday_schedules_date','monday_schedules_date','tuesday_schedules_date','wednesday_schedules_date','thursday_schedules_date','medical_test','drug_test','criminal_check','work_place','neighbourhood','credit_check','references_personal','references_work','references_school','references_living_area','method_online','method_phone','method_in_person','tenant_responsibilities','trems_accept','inserted_by','updated_by','status_active','is_deleted',  
   ];
}

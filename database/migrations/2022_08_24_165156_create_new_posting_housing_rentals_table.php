<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewPostingHousingRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_posting_housing_rentals', function (Blueprint $table) {
                $table->increments('id');
				$table->Integer('project_id')->default(0);
				$table->Integer('user_id')->default(0);
				$table->Integer('posting_prefix')->default(0);
				$table->string('posting_no', 200)->nullable($value = true);
				$table->string('genaral_posting_title', 200)->nullable($value = true);
				$table->Integer('landlord')->default(0); 
				$table->Integer('leaseholder')->default(0);
				$table->Integer('tenant')->default(0);
				$table->Integer('shareholder')->default(0); 
				$table->Integer('posting_employee')->default(0); 
				$table->Integer('servive_provider')->default(0); 
				$table->Integer('seller')->default(0); 
				$table->Integer('guest')->default(0);
				$table->Integer('visitor')->default(0); 
				$table->string('post_user_id', 200)->nullable($value = true);
				$table->string('post_name', 200)->nullable($value = true);
				$table->string('post_rank', 200)->nullable($value = true);
				$table->Integer('posting_user_type')->default(0);
				$table->Integer('posting_class')->default(0);
				$table->Integer('payment_status')->default(0);
				$table->Integer('posting_status')->default(0);
				$table->Integer('restrictions_air_bnb')->default(0);
				$table->string('employer_number', 200)->nullable($value = true);
				$table->string('company_address', 200)->nullable($value = true);
				$table->string('employer_companay_name', 200)->nullable($value = true);
				$table->string('company_website', 200)->nullable($value = true);
				$table->string('full_legal_name', 200)->nullable($value = true);
				$table->string('company_about_us', 200)->nullable($value = true);
				$table->string('company_contacts', 200)->nullable($value = true);
				$table->date('new_posting_date')->nullable($value = true);
				$table->date('renew_posting_date')->nullable($value = true);
				$table->date('reported_posting_date')->nullable($value = true);
				$table->date('Paid_posting_date')->nullable($value = true);
				$table->date('edited_posting_date')->nullable($value = true);
				$table->date('validation_period_posting_date')->nullable($value = true);
				$table->date('posted_posting_date')->nullable($value = true);
				$table->date('expired_posting_date')->nullable($value = true);
				$table->date('re_posting_date')->nullable($value = true);
				$table->date('publised_posting_date')->nullable($value = true);
				$table->date('removing_posting_date')->nullable($value = true);
				$table->string('leaseholder_id_number', 200)->nullable($value = true);
				$table->string('leaseholder_name', 200)->nullable($value = true);
				$table->string('bms_contact_info', 200)->nullable($value = true);
				$table->string('building_name', 200)->nullable($value = true);
				$table->string('building_address', 200)->nullable($value = true);
 				$table->Integer('studio')->default(0); 
				$table->Integer('one_bed')->default(0); 
				$table->Integer('two_bed')->default(0); 
				$table->Integer('three_bed')->default(0); 
				$table->Integer('penthouse')->default(0); 
				$table->Integer('parking_stall')->default(0); 
				$table->Integer('storage_lockers')->default(0); 
				$table->Integer('commercial_unit')->default(0); 
				$table->string('map_link', 200)->nullable($value = true);
 				$table->string('number_of_room', 200)->nullable($value = true);
				$table->string('number_of_den', 200)->nullable($value = true);
				$table->string('number_of_solarium', 200)->nullable($value = true);
				$table->string('number_of_kitchen', 200)->nullable($value = true);
				$table->string('number_of_bathroom', 200)->nullable($value = true);
				$table->string('number_of_washroom', 200)->nullable($value = true);
				$table->Integer('size_type')->default(0); 
				$table->string('number_of_sqft', 200)->nullable($value = true);
				$table->Integer('neighborhood_type')->default(0); 
				$table->string('neighborhood_name', 200)->nullable($value = true);
				$table->string('neighborhood_address', 200)->nullable($value = true);
				$table->string('neighborhood_distance', 200)->nullable($value = true);
				$table->string('neighborhood_map_link', 200)->nullable($value = true);
 				$table->Integer('allowed_bbq')->default(0); 
				$table->Integer('allowed_smoke')->default(0); 
				$table->Integer('allowed_pet')->default(0); 
				$table->Integer('allowed_max_guest')->default(0); 
				$table->Integer('restrictions_sublease')->default(0); 
				$table->Integer('restrictions_max_tenant')->default(0); 
				$table->Integer('restrictions_shared_room')->default(0); 
				$table->Integer('no_music')->default(0); 
				$table->Integer('no_landry_and_washing_machine')->default(0); 
				$table->Integer('pre_authorized_payment')->default(0);
 				$table->Integer('email_transfer')->default(0);
				$table->Integer('cash')->default(0);
				$table->Integer('check')->default(0);
				$table->Integer('credit_card')->default(0); 
 				$table->string('move_in_out_requirements', 200)->nullable($value = true);
				$table->date('availability_date')->nullable($value = true);
				$table->date('saturday_schedules_date')->nullable($value = true);
				$table->date('sunday_schedules_date')->nullable($value = true);
				$table->date('monday_schedules_date')->nullable($value = true);
				$table->date('tuesday_schedules_date')->nullable($value = true);
				$table->date('wednesday_schedules_date')->nullable($value = true);
				$table->date('thursday_schedules_date')->nullable($value = true);
  				$table->Integer('medical_test')->default(0); 
				$table->Integer('drug_test')->default(0); 
				$table->Integer('criminal_check')->default(0); 
				$table->Integer('work_place')->default(0); 
				$table->Integer('neighbourhood')->default(0); 
				$table->Integer('credit_check')->default(0); 
				$table->Integer('references_personal')->default(0); 
				$table->Integer('references_work')->default(0); 
				$table->Integer('references_school')->default(0); 
				$table->Integer('references_living_area')->default(0); 
				$table->Integer('method_online')->default(0); 
				$table->Integer('method_phone')->default(0); 
				$table->Integer('method_in_person')->default(0); 
 				$table->string('tenant_responsibilities', 200)->nullable($value = true);
				$table->Integer('trems_accept')->default(0); 
 				$table->Integer('inserted_by')->default(0);
				$table->Integer('updated_by')->default(0);
				$table->tinyInteger('status_active')->default(1)->index();
				$table->tinyInteger('is_deleted')->default(0)->index();
				$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_posting_housing_rentals');
    }
}

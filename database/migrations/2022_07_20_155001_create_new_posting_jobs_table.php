<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewPostingJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_posting_jobs', function (Blueprint $table) {
  
            $table->increments('id');
            $table->Integer('project_id')->default(0);
            $table->Integer('user_id')->default(0);
            $table->string('post_user_id', 200)->nullable($value = true);
            $table->string('post_name', 200)->nullable($value = true);
            $table->string('post_rank', 200)->nullable($value = true); 
            $table->Integer('posting_user_type')->default(0); 
            $table->Integer('posting_class')->default(0);
            $table->Integer('payment_status')->default(0);
            $table->Integer('posting_status')->default(0);   
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
            $table->tinyInteger('landlord')->default(0);
            $table->tinyInteger('leaseholder')->default(0);
            $table->tinyInteger('tenant')->default(0);
            $table->tinyInteger('shareholder')->default(0);
            $table->tinyInteger('servive_provider')->default(0);
            $table->tinyInteger('seller')->default(0);
            $table->tinyInteger('guest')->default(0);
            $table->tinyInteger('visitor')->default(0); 
            $table->string('employer_number', 200)->nullable($value = true);
            $table->string('employer_companay_name', 200)->nullable($value = true);
            $table->string('full_legal_name', 200)->nullable($value = true);
            $table->string('company_address', 300)->nullable($value = true);
            $table->string('company_website', 200)->nullable($value = true);
            $table->string('company_contacts', 200)->nullable($value = true);
            $table->string('company_about_us', 300)->nullable($value = true);
            $table->string('posting_title', 300)->nullable($value = true);
            $table->string('job_title', 300)->nullable($value = true);
            $table->Integer('Employment_self_employed')->default(0);
            $table->Integer('full_part_time')->default(0);
            $table->string('hourly_rate', 100)->nullable($value = true);
            $table->string('monthly_salary', 100)->nullable($value = true);
            $table->string('posting_benefits', 200)->nullable($value = true);
            $table->string('job_description', 300)->nullable($value = true);
            $table->string('posting_responsibilities', 300)->nullable($value = true);
            $table->string('education_lavel', 200)->nullable($value = true);
            $table->string('posting_skills', 200)->nullable($value = true);
            $table->Integer('job_experience')->default(0);
            $table->Integer('permit_license')->default(0);
            $table->string('work_location', 150)->nullable($value = true);
            $table->Integer('days_hours')->default(0);
            $table->Integer('overtime_allowed')->default(0);
            $table->Integer('probation_period')->default(0);
            $table->Integer('posting_bondable')->default(0);
            $table->Integer('contract_requited')->default(0);
            $table->tinyInteger('medical_test')->default(0);
            $table->tinyInteger('drug')->default(0);
            $table->tinyInteger('criminal_check')->default(0);
            $table->tinyInteger('personal')->default(0);
            $table->tinyInteger('work')->default(0);
            $table->tinyInteger('school')->default(0);
            $table->tinyInteger('living_area')->default(0);
            $table->tinyInteger('online')->default(0);
            $table->tinyInteger('phone')->default(0);
            $table->tinyInteger('in_person')->default(0);
            $table->string('posting_note', 500)->nullable($value = true);
            $table->Integer('posting_accept')->default(0); 
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
        Schema::dropIfExists('new_posting_jobs');
    }
}

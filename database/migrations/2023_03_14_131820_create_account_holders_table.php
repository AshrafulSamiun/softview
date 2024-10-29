<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountHoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_holders', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('system_prefix')->default(0);
            $table->string('system_no', 50)->nullable($value = true);
            $table->Integer('account_type')->default(0);
            $table->Integer('entity_type')->default(0);
            $table->string('first_name')->nullable($value = true);
            $table->string('middle_name')->nullable($value = true);
            $table->string('last_name')->nullable($value = true);
            $table->Integer('industry_sector')->default(0);
            $table->string('reg_cor_dir_info')->nullable($value = true);
            $table->string('register_corp_first_name')->nullable($value = true);
            $table->string('register_corp_middle_name')->nullable($value = true);
            $table->string('register_corp_last_name')->nullable($value = true);
            $table->string('register_corp_phone_no')->nullable($value = true);
            $table->string('register_corp_email')->nullable($value = true);
            $table->string('register_emergency_contact')->nullable($value = true);
            $table->string('house_number',50)->nullable($value = true);
            $table->string('street_number',50)->nullable($value = true);
            $table->string('city',100)->nullable($value = true);
            $table->string('state',100)->nullable($value = true);
            $table->Integer('country')->default(0);
            $table->string('zip_code',50)->nullable($value = true);
            $table->string('email')->nullable($value = true);
            $table->string('fax_no',50)->nullable($value = true);
            $table->string('cell_phone',20)->nullable($value = true);
            $table->string('website',120)->nullable($value = true);


            $table->string('business_license_issued_by',150)->nullable($value = true);
            $table->string('business_license_house_number',50)->nullable($value = true);
            $table->string('business_license_street_number',50)->nullable($value = true);
            $table->string('business_license_city',100)->nullable($value = true);
            $table->string('business_license_state',100)->nullable($value = true);
            $table->Integer('business_license_country')->default(0);
            $table->string('business_license_zip_code',50)->nullable($value = true);
            $table->string('business_license_email')->nullable($value = true);
            $table->string('business_license_fax_no',50)->nullable($value = true);
            $table->string('business_license_cell_phone',20)->nullable($value = true);
            $table->string('business_license_website',120)->nullable($value = true);
            $table->string('business_license_no',120)->nullable($value = true);
            $table->date('business_license_issue_date')->nullable($value = true);
            $table->date('business_license_expire_date')->nullable($value = true);
            $table->tinyInteger('business_license_is_callender')->default(0);
            $table->tinyInteger('business_license_validation_status')->default(0);

            $table->string('professional_license_associate_name',150)->nullable($value = true);
            $table->string('professional_license_house_number',50)->nullable($value = true);
            $table->string('professional_license_street_number',50)->nullable($value = true);
            $table->string('professional_license_city',100)->nullable($value = true);
            $table->string('professional_license_state',100)->nullable($value = true);
            $table->Integer('professional_license_country')->default(0);
            $table->string('professional_license_zip_code',50)->nullable($value = true);
            $table->string('professional_license_email')->nullable($value = true);
            $table->string('professional_license_fax_no',50)->nullable($value = true);
            $table->string('professional_license_cell_phone',20)->nullable($value = true);
            $table->string('professional_license_website',120)->nullable($value = true);
            $table->string('professional_license_no',120)->nullable($value = true);
            $table->date('professional_license_issue_date')->nullable($value = true);
            $table->date('professional_license_expire_date')->nullable($value = true);
            $table->tinyInteger('professional_license_is_callender')->default(0);
            $table->tinyInteger('professional_license_validation_status')->default(0);

            $table->string('liabilities_insurence_issued_by',150)->nullable($value = true);
            $table->string('liabilities_insurence_house_number',50)->nullable($value = true);
            $table->string('liabilities_insurence_street_number',50)->nullable($value = true);
            $table->string('liabilities_insurence_city',100)->nullable($value = true);
            $table->string('liabilities_insurence_state',100)->nullable($value = true);
            $table->Integer('liabilities_insurence_country')->default(0);
            $table->string('liabilities_insurence_zip_code',50)->nullable($value = true);
            $table->string('liabilities_insurence_email')->nullable($value = true);
            $table->string('liabilities_insurence_fax_no',50)->nullable($value = true);
            $table->string('liabilities_insurence_cell_phone',20)->nullable($value = true);
            $table->string('liabilities_insurence_website',120)->nullable($value = true);
            $table->string('liabilities_insurence_no',120)->nullable($value = true);
            $table->date('liabilities_insurence_issue_date')->nullable($value = true);
            $table->date('liabilities_insurence_expire_date')->nullable($value = true);
            $table->tinyInteger('liabilities_insurence_is_callender')->default(0);
            $table->tinyInteger('liabilities_insurence_validation_status')->default(0);
            
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
        Schema::dropIfExists('account_holders');
    }
}

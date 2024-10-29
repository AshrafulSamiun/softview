<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('account_prefix')->default(0);
            $table->Integer('account_no')->default(0);
            $table->tinyInteger('scope_of_operation')->default(0);
            $table->integer('company_logo_id')->nullable($value = true);
            
            $table->string('legal_name', 200);
            $table->string('business_registration_number', 200)->nullable($value = true);
            $table->date('registration_date')->nullable($value = true);
            $table->string('business_registration_city', 130)->nullable($value = true);
            $table->string('business_registration_state', 150)->nullable($value = true);
            $table->Integer('registration_country')->default(0);
            
            $table->string('business_license_no', 200)->nullable($value = true);
            $table->string('issued_by', 200)->nullable($value = true);
            $table->string('license_state', 150)->nullable($value = true);
            $table->Integer('license_country')->default(0);
            $table->date('expirey_date')->nullable($value = true);
            
           
            $table->string('headoffice_house_number', 150)->nullable($value = true);
            $table->string('headoffice_street_number', 150)->nullable($value = true);
            $table->string('headoffice_city', 150)->nullable($value = true);
            $table->string('headoffice_state', 150)->nullable($value = true);
            $table->Integer('headoffice_country')->default(0);
            $table->string('headoffice_zip_code', 50)->nullable($value = true);

            $table->string('contact_person_email',100)->nullable($value = true);
            $table->string('contact_person_fax_no',100)->nullable($value = true);
            $table->string('contact_person_cell_phone',100)->nullable($value = true);
            $table->string('contact_person_website', 100)->nullable($value = true);

            $table->tinyInteger('property_management')->default(0);
            $table->tinyInteger('strata_management')->default(0);
            $table->tinyInteger('parking_management_industry')->default(0);
            $table->tinyInteger('storage_management_company')->default(0);
            $table->tinyInteger('leasehold_management')->default(0);
            $table->tinyInteger('calender_property_manager')->default(0);
            $table->tinyInteger('calender_general_manager')->default(0);
            $table->tinyInteger('calender_building_manager')->default(0);
            $table->tinyInteger('calender_accounts_payable')->default(0);
            $table->tinyInteger('calender_accounting_manager')->default(0);
            $table->tinyInteger('calender_director')->default(0);
            $table->tinyInteger('calender_network_administrator')->default(0);
            $table->tinyInteger('customer_property_management')->default(0);
            $table->tinyInteger('customer_seller')->default(0);
            $table->tinyInteger('customer_service_provider')->default(0);


            $table->date('fiscal_year_start_date')->nullable($value = true);
            $table->date('fiscal_year_end_date')->nullable($value = true);

           
            $table->tinyInteger('fiscal_year_in_calender')->default(0);
            $table->tinyInteger('recuring_cycle')->default(0);
            $table->tinyInteger('comment_in_calender')->default(0);
            $table->text('comments')->nullable($value = true);
            $table->timestamp('comment_date');
            
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
        Schema::dropIfExists('companies');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('user_id')->default(0)->index();
            $table->tinyInteger('type_of_operation')->default(0);
            $table->tinyInteger('management_type')->default(0);
            $table->tinyInteger('strata_management')->default(0);
            $table->tinyInteger('coop_property')->default(0);
            $table->tinyInteger('free_hold_management')->default(0);
            $table->tinyInteger('leasehold_management')->default(0);
            $table->tinyInteger('property_management')->default(0);
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
            $table->integer('company_logo_id')->nullable($value = true);
           /* $table->string('head_office_email',100)->nullable($value = true);
            $table->string('head_office_fax_no',100)->nullable($value = true);
            $table->string('head_office_cell_phone',100)->nullable($value = true);
            $table->string('head_office_website', 100)->nullable($value = true);*/

            $table->string('headoffice_street_number', 150)->nullable($value = true);
            $table->string('headoffice_city', 150)->nullable($value = true);
            $table->string('headoffice_state', 150)->nullable($value = true);
            $table->Integer('headoffice_country')->default(0);

            $table->string('contact_person_email',100)->nullable($value = true);
            $table->string('contact_person_fax_no',100)->nullable($value = true);
            $table->string('contact_person_cell_phone',100)->nullable($value = true);
            $table->string('contact_person_website', 100)->nullable($value = true);
            $table->string('business_number', 130)->nullable($value = true);           
            $table->string('emp_identification_number', 200)->nullable($value = true);
            $table->string('payroll', 200)->nullable($value = true);
            $table->string('sales_tax', 200)->nullable($value = true);
            $table->string('income_tax',100)->nullable($value = true);
            $table->string('import_and_export',200)->nullable($value = true);
            $table->tinyInteger('dependent_residential_suite')->default(0);
            $table->tinyInteger('dependent_residental_parking_lot')->default(0);
            $table->tinyInteger('dependent_residental_storage_lot')->default(0);
            $table->tinyInteger('dependent_commercial_unit')->default(0);
            $table->tinyInteger('dependent_commercial_parking_lot')->default(0);
            $table->tinyInteger('dependent_commercial_storage_lot')->default(0);
            $table->tinyInteger('independent_residential_suite')->default(0);
            $table->tinyInteger('independent_residental_parking_lot')->default(0);
            $table->tinyInteger('independent_residental_storage_lot')->default(0);
            $table->tinyInteger('independent_commercial_unit')->default(0);
            $table->tinyInteger('independent_commercial_parking_lot')->default(0);
            $table->tinyInteger('independent_commercial_storage_lot')->default(0);
            $table->tinyInteger('rantal_suite_unit')->default(0);
            $table->tinyInteger('buy_and_sell_suite_unit')->default(0);
            $table->tinyInteger('rental_parking')->default(0);
            $table->tinyInteger('rental_storage')->default(0);
            $table->tinyInteger('landholders_residency')->default(0);
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
        Schema::dropIfExists('account_companies');
    }
}

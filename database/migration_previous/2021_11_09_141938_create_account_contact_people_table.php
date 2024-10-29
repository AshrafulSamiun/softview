<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountContactPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_contact_people', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->string('head_office_legal_name', 200)->nullable($value = true);
            $table->string('authorize_person_legal_name', 200)->nullable($value = true);
            $table->string('account_payable_legal_name', 200)->nullable($value = true);
            $table->string('contact_person_legal_name', 200)->nullable($value = true);
            $table->string('system_admin_legal_name', 200)->nullable($value = true);


            $table->string('head_office_country', 200)->nullable($value = true);
            $table->string('authorize_person_country', 200)->nullable($value = true);
            $table->string('account_payable_country', 200)->nullable($value = true);
            $table->string('contact_person_country', 200)->nullable($value = true);
            $table->string('system_admin_country', 200)->nullable($value = true);



            $table->string('head_office_provience', 200)->nullable($value = true);
            $table->string('authorize_person_provience', 200)->nullable($value = true);
            $table->string('account_payable_provience', 200)->nullable($value = true);
            $table->string('contact_person_provience', 200)->nullable($value = true);
            $table->string('system_admin_provience', 200)->nullable($value = true);

            $table->string('head_office_city', 200)->nullable($value = true);
            $table->string('authorize_person_city', 200)->nullable($value = true);
            $table->string('account_payable_city', 200)->nullable($value = true);
            $table->string('contact_person_city', 200)->nullable($value = true);
            $table->string('system_admin_city', 200)->nullable($value = true);

            $table->string('head_office_street_no', 200)->nullable($value = true);
            $table->string('authorize_person_street_no', 200)->nullable($value = true);
            $table->string('account_payable_street_no', 200)->nullable($value = true);
            $table->string('contact_person_street_no', 200)->nullable($value = true);
            $table->string('system_admin_street_no', 200)->nullable($value = true);

            $table->string('head_office_postal_code', 200)->nullable($value = true);
            $table->string('authorize_person_postal_code', 200)->nullable($value = true);
            $table->string('account_payable_postal_code', 200)->nullable($value = true);
            $table->string('contact_person_postal_code', 200)->nullable($value = true);
            $table->string('system_admin_postal_code', 200)->nullable($value = true);

            $table->string('head_office_po_box', 200)->nullable($value = true);
            $table->string('authorize_person_po_box', 200)->nullable($value = true);
            $table->string('account_payable_po_box', 200)->nullable($value = true);
            $table->string('contact_person_po_box', 200)->nullable($value = true);
            $table->string('system_admin_po_box', 200)->nullable($value = true);

            $table->string('head_office_bussiness_no', 200)->nullable($value = true);
            $table->string('authorize_person_bussiness_no', 200)->nullable($value = true);
            $table->string('account_payable_bussiness_no', 200)->nullable($value = true);
            $table->string('contact_person_bussiness_no', 200)->nullable($value = true);
            $table->string('system_admin_bussiness_no', 200)->nullable($value = true);

            $table->string('head_office_office_phone', 200)->nullable($value = true);
            $table->string('authorize_person_office_phone', 200)->nullable($value = true);
            $table->string('account_payable_office_phone', 200)->nullable($value = true);
            $table->string('contact_person_office_phone', 200)->nullable($value = true);
            $table->string('system_admin_office_phone', 200)->nullable($value = true);

            $table->string('head_office_cell_phone', 200)->nullable($value = true);
            $table->string('authorize_person_cell_phone', 200)->nullable($value = true);
            $table->string('account_payable_cell_phone', 200)->nullable($value = true);
            $table->string('contact_person_cell_phone', 200)->nullable($value = true);
            $table->string('system_admin_cell_phone', 200)->nullable($value = true);



            $table->string('head_office_fax_no', 200)->nullable($value = true);
            $table->string('authorize_person_fax_no', 200)->nullable($value = true);
            $table->string('account_payable_fax_no', 200)->nullable($value = true);
            $table->string('contact_person_fax_no', 200)->nullable($value = true);
            $table->string('system_admin_fax_no', 200)->nullable($value = true);

            $table->string('head_office_email', 200)->nullable($value = true);
            $table->string('authorize_person_email', 200)->nullable($value = true);
            $table->string('account_payable_email', 200)->nullable($value = true);
            $table->string('contact_person_email', 200)->nullable($value = true);
            $table->string('system_admin_email', 200)->nullable($value = true);


            $table->string('head_office_website', 200)->nullable($value = true);
            $table->string('authorize_person_website', 200)->nullable($value = true);
            $table->string('account_payable_website', 200)->nullable($value = true);
            $table->string('contact_person_website', 200)->nullable($value = true);
            $table->string('system_admin_website', 200)->nullable($value = true);


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
        Schema::dropIfExists('account_contact_people');
    }
}

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
            $table->Integer('contact_person_id')->default(0)->index();
            $table->string('full_name', 200)->nullable($value = true);
            $table->string('job_title', 100)->nullable($value = true);
            $table->string('street_number', 100)->nullable($value = true);
            $table->string('city', 100)->nullable($value = true);
            $table->string('state', 100)->nullable($value = true);


            $table->Integer('country')->default(0);
            $table->string('post_code', 100)->nullable($value = true);
            $table->string('po_box', 100)->nullable($value = true);
            $table->string('office_phone', 100)->nullable($value = true);
            $table->string('mobile', 100)->nullable($value = true);



            $table->string('email', 100)->nullable($value = true);
            $table->string('fax_no', 100)->nullable($value = true);
            
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

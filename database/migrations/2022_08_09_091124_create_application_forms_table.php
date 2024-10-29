<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('system_prefix')->default(0);
            $table->string('system_no', 50)->nullable($value = true);
            $table->string('full_name', 50)->nullable($value = true);
            $table->integer('ba_number')->nullable($value = true);
            $table->tinyInteger('rank')->nullable($value = true);

            $table->string('unit', 400)->nullable($value = true);
            $table->string('mobile_no', 100)->nullable($value = true);

            $table->string('service_length', 100)->nullable($value = true);
            $table->string('plot', 150)->nullable($value = true);
            $table->string('road', 150)->nullable($value = true);
            $table->string('current_address', 4000)->nullable($value = true);
            $table->string('permanent_address', 4000)->nullable($value = true);
            $table->string('nok_name', 150)->nullable($value = true);
            $table->tinyInteger('sector')->default(0);
            $table->Integer('city')->default(0);
            $table->tinyInteger('soil_test')->nullable($value = true);
            $table->date('soil_test_date')->nullable($value = true);
            $table->tinyInteger('structural_design')->nullable($value = true);
            $table->string('tin_no', 200)->nullable($value = true);
            $table->string('national_id_no', 200)->nullable($value = true);
            $table->string('bank_account_no', 200)->nullable($value = true);
            $table->string('required_number_of_piles',50)->nullable($value = true);
            $table->string('depth_of_each_piles', 1000)->nullable($value = true);

            $table->date('ex_piling_date')->nullable($value = true);

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
        Schema::dropIfExists('application_forms');
    }
}

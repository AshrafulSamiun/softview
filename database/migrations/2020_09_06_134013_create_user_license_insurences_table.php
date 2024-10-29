<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLicenseInsurencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_license_insurences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->Integer('project_id')->default(0)->index();

            $table->date('permit_start')->nullable($value = true);
            $table->date('permit_end')->nullable($value = true);
            $table->date('permit_expire_date')->nullable($value = true);
            $table->Integer('permit_image_id')->nullable($value = true);

            $table->date('license_start')->nullable($value = true);
            $table->date('license_end')->nullable($value = true);
            $table->date('license_expire_date')->nullable($value = true);
            $table->Integer('license_image_id')->nullable($value = true);

            $table->date('liability_start')->nullable($value = true);
            $table->date('liability_end')->nullable($value = true);
            $table->date('liability_expire_date')->nullable($value = true);
            $table->Integer('liability_image_id')->nullable($value = true);

            $table->date('home_insurence_start')->nullable($value = true);
            $table->date('home_insurence_end')->nullable($value = true);
            $table->date('home_insurence_expire_date')->nullable($value = true);
            $table->Integer('home_insurence_image_id')->nullable($value = true);

            $table->date('car_insurence_start')->nullable($value = true);
            $table->date('car_insurence_end')->nullable($value = true);
            $table->date('car_insurence_expire_date')->nullable($value = true);
            $table->Integer('car_insurence_image_id')->nullable($value = true);

            $table->integer('inserted_by')->default(0);
            $table->integer('updated_by')->default(0);
            $table->tinyInteger('status_active')->default(1);
            $table->tinyInteger('is_deleted')->default(0);
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
        Schema::dropIfExists('user_license_insurences');
    }
}

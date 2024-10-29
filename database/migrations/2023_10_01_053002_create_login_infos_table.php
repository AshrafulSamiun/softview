<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('login_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('user_id')->default(0)->index();
            $table->string('ip_address',100)->nullable($value = true);
            $table->string('country_name',200)->nullable($value = true);
            $table->string('country_code',20)->nullable($value = true);
            $table->string('city_name',200)->nullable($value = true);
            $table->string('region_code',50)->nullable($value = true);
            $table->string('region_name',100)->nullable($value = true);
            $table->string('zip_code',20)->nullable($value = true);
            $table->string('time_zone',150)->nullable($value = true);
            $table->string('device_name',200)->nullable($value = true);
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
        Schema::dropIfExists('login_infos');
    }
}

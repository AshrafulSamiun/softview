<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('plan_name',200)->nullable($value = true);
            $table->tinyInteger('management_type')->default(1);
            $table->tinyInteger('type_of_service')->default(10);
            $table->double('rate',8,2)->default(0.00);
            $table->double('amount',8,2)->default(0.00);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('slno')->default(0);
            $table->tinyInteger('rate_applicable')->default(0);
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
        Schema::dropIfExists('service_plans');
    }
}

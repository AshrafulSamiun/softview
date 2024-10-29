<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->Integer('project_id')->default(0)->index();
            $table->string('vihicle_model_no', 100)->nullable($value = true);
            $table->Integer('vihicle_model_year')->nullable($value = true);

            $table->string('vihicle_color', 100)->nullable($value = true);;
            $table->string('vihicle_plate_no', 50)->nullable($value = true);
            $table->date('vihicle_ins_exp_date')->nullable($value = true);
         
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
        Schema::dropIfExists('user_vehicles');
    }
}

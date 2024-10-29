<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildingPropertyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_property_details', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->integer('master_id')->nullable($value = true);
            $table->integer('floor_no')->nullable($value = true);
            $table->tinyInteger('floor_type')->nullable($value = true);

           
            $table->integer('total_suite')->nullable($value = true);
            $table->integer('total_unit')->nullable($value = true);
            $table->integer('total_mechanical_room')->nullable($value = true);
            $table->integer('total_administrative_room')->nullable($value = true);
            $table->integer('total_amenity_room')->nullable($value = true);
            $table->integer('total_service_room')->nullable($value = true);
            $table->integer('total_parking_lot')->nullable($value = true);
            $table->integer('total_bike_lot')->nullable($value = true);
            $table->integer('total_storage_lot')->nullable($value = true);
            $table->integer('total_mailroom')->nullable($value = true);
            $table->integer('total_common_area')->nullable($value = true);
           
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
        Schema::dropIfExists('building_property_details');
    }
}

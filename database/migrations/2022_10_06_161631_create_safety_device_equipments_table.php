<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSafetyDeviceEquipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('safety_device_equipments', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->tinyInteger('page_id')->default(0)->index();
            $table->integer('master_id')->nullable($value = true);
            $table->integer('item_id')->nullable($value = true);
            $table->integer('reference_id')->nullable($value = true);
            $table->string('reference_name', 150)->nullable($value = true);
            $table->string('name', 150)->nullable($value = true);
            $table->string('floor_no', 150)->nullable($value = true);
            $table->string('serial_no', 150)->nullable($value = true);
            $table->date('expiry_date')->nullable($value = true);
            $table->date('renew_date')->nullable($value = true);
            $table->date('due_on')->nullable($value = true);
            $table->tinyInteger('cicle')->nullable($value = true);
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
        Schema::dropIfExists('safety_device_equipments');
    }
}

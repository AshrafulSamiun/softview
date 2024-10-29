<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorageLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('building_name')->default(0);
            $table->Integer('master_id')->default(0)->index();
            $table->Integer('details_id')->nullable($value = true);
            $table->string('item_name', 250)->nullable($value = true);
            $table->Integer('system_prefix')->default(0);
            $table->string('system_no', 50)->nullable($value = true);
            $table->string('property_name')->nullable($value = true);
            $table->tinyInteger('uom')->nullable($value = true);
            $table->Integer('item_size')->nullable($value = true);
            $table->tinyInteger('storage_type_1')->default(2);
            $table->tinyInteger('storage_type_2')->default(2);
            $table->tinyInteger('storage_type_3')->default(2);
            $table->tinyInteger('storage_type_4')->default(2);
            $table->tinyInteger('storage_type_5')->default(2);
            $table->tinyInteger('storage_type_6')->default(2);
            $table->tinyInteger('storage_type_7')->default(2);
            $table->tinyInteger('storage_type_8')->default(2);
            $table->tinyInteger('storage_type_9')->default(2);
            $table->tinyInteger('storage_type_10')->default(2);
            $table->tinyInteger('storage_type_11')->default(2);
            $table->tinyInteger('storage_type_12')->default(2);
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
        Schema::dropIfExists('storage_levels');
    }
}

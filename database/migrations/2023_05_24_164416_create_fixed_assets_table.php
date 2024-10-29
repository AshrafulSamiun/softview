<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixedAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('asset_category')->default(0)->index();
            $table->Integer('sub_category')->default(0)->index();
            $table->Integer('system_prefix')->default(0);
            $table->string('system_no', 50)->nullable($value = true);
            $table->string('asset_name', 200)->nullable($value = true);
            $table->string('serial_no',50)->nullable($value = true);
            $table->string('barcode',50)->nullable($value = true);
            $table->tinyInteger('uom')->nullable($value = true);
            $table->tinyInteger('condition')->nullable($value = true);
            $table->string('model',100)->nullable($value = true);
            $table->string('color',100)->nullable($value = true);
            $table->string('comments',500)->nullable($value = true);
            $table->tinyInteger('length_uom')->nullable($value = true);
            $table->string('item_length',50)->nullable($value = true);
            $table->tinyInteger('width_uom')->nullable($value = true);
            $table->string('item_width',50)->nullable($value = true);
            $table->tinyInteger('height_uom')->nullable($value = true);
            $table->string('item_height',50)->nullable($value = true);
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
        Schema::dropIfExists('fixed_assets');
    }
}

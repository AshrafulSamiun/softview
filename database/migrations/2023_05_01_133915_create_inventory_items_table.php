<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('item_category')->default(0)->index();
            $table->Integer('system_prefix')->default(0);
            $table->string('system_no', 50)->nullable($value = true);
            $table->string('item_name', 200)->nullable($value = true);
            $table->string('item_description',250)->nullable($value = true);
            $table->tinyInteger('uom')->nullable($value = true);
            $table->tinyInteger('condition')->nullable($value = true);
            $table->string('model',200)->nullable($value = true);
            $table->string('storage_requirement',500)->nullable($value = true);
            $table->tinyInteger('negative_quantity')->nullable($value = true);
            $table->tinyInteger('negative_amount')->nullable($value = true);
            $table->string('minimum_quantity',200)->nullable($value = true);
            $table->string('maxmum_quantity',200)->nullable($value = true);
            $table->tinyInteger('length_uom')->nullable($value = true);
            $table->string('item_length',50)->nullable($value = true);
            $table->tinyInteger('width_uom')->nullable($value = true);
            $table->string('item_width',50)->nullable($value = true);
            $table->tinyInteger('height_uom')->nullable($value = true);
            $table->string('item_height',50)->nullable($value = true);
            $table->tinyInteger('purchase_tax')->nullable($value = true);
            $table->tinyInteger('sales_tax')->nullable($value = true);
            $table->tinyInteger('active')->nullable($value = true);
            $table->string('chart_of_account', 50)->nullable($value = true);
            $table->Integer('chart_of_account_id')->default(0);
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
        Schema::dropIfExists('inventory_items');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddsOnItemsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adds_on_items_details', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0);
            $table->Integer('user_id')->default(0);
			$table->Integer('mst_id')->default(0);
			$table->Integer('reference_id')->default(0);
            $table->string('adds_on_item_name', 200)->nullable($value = true);
			$table->Integer('yes_no')->default(0); 
			$table->Integer('size_sqft')->default(0);  
			$table->Integer('amount')->default(0);  
			$table->string('Comments', 300)->nullable($value = true);
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
        Schema::dropIfExists('adds_on_items_details');
    }
}

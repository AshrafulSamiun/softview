<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildingContactDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_contact_details', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->tinyInteger('page_id')->default(0)->index();

            $table->integer('master_id')->nullable($value = true);
            $table->integer('reference_id')->nullable($value = true);
            $table->string('item_name', 150)->nullable($value = true);
            $table->string('contact_no', 150)->nullable($value = true);

            $table->string('comment', 4000)->nullable($value = true);
            $table->string('phone', 50)->nullable($value = true);
            $table->string('website', 150)->nullable($value = true);
            $table->string('mobile', 50)->nullable($value = true);
            $table->string('email', 100)->nullable($value = true);
            $table->string('hours_of_operation', 250)->nullable($value = true);
    
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
        Schema::dropIfExists('building_contact_details');
    }
}

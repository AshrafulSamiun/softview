<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuildingInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->integer('company_name')->nullable($value = true);
            $table->integer('customer_name')->nullable($value = true);
            $table->Integer('system_prefix')->default(0);
            $table->string('building_no', 50)->nullable($value = true);
            $table->string('building_name',250)->nullable($value = true);
            $table->string('strata_lot_no',100)->nullable($value = true);
            $table->tinyInteger('posting_status')->default(0)->nullable($value = true);
            $table->tinyInteger('building_uom')->default(1);
            $table->double('total_building_size',8,2)->default(0.00);
            $table->integer('number_of_floor')->nullable($value = true);
            $table->integer('number_of_upper_floor')->nullable($value = true);
            $table->tinyInteger('number_of_ground_floor')->nullable($value = true);
            $table->tinyInteger('number_of_under_ground')->nullable($value = true);
            $table->tinyInteger('dependent_building')->nullable($value = true);
            $table->tinyInteger('independent_building')->nullable($value = true);
            $table->tinyInteger('residential')->nullable($value = true);
            $table->tinyInteger('commercial')->nullable($value = true);
            $table->tinyInteger('residential_commercial')->nullable($value = true);
            $table->tinyInteger('posting_status')->default(0)->nullable($value = true);

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
        Schema::dropIfExists('building_infos');
    }
}

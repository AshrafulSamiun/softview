<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFloorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('floors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('floor_name', 250)->nullable($value = true);
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('company_name')->nullable($value = true);
            $table->string('strata_lot_no',100)->nullable($value = true);
            $table->tinyInteger('posting_status')->default(0)->nullable($value = true);
            $table->Integer('building_name')->default(0);
            $table->Integer('floor_no')->default(0);
            $table->Integer('system_prefix')->default(0);
            $table->string('system_no', 50)->nullable($value = true);
            
                   
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
        Schema::dropIfExists('floors');
    }
}

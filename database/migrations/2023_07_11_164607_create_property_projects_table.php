<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('master_id')->default(0)->index();
            $table->string('system_no',50)->nullable($value = true);
            $table->Integer('system_prefix')->nullable($value = true);
            $table->string('project_name',500)->nullable($value = true);
            $table->string('subject_title',150)->nullable($value = true);
            $table->tinyInteger('current_status')->nullable($value = true);
            $table->tinyInteger('building_type')->nullable($value = true);
            $table->Integer('building_id')->default(0)->index();
            $table->Integer('contractor_id')->default(0)->index();
            $table->string('contractor_id_no')->nullable($value = true);
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
        Schema::dropIfExists('property_projects');
    }
}

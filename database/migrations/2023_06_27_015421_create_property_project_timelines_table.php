<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyProjectTimelinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_project_timelines', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('master_id')->default(0)->index();
            $table->string('task_details',300)->nullable($value = true);
            $table->date('from_date')->nullable($value = true);
            $table->date('to_date')->nullable($value = true);
            $table->string('hours',30)->nullable($value = true);
            $table->string('days',30)->nullable($value = true);
            $table->date('resedule_from_date1')->nullable($value = true);
            $table->date('resedule_to_date1')->nullable($value = true);
            $table->date('resedule_from_date2')->nullable($value = true);
            $table->date('resedule_to_date2')->nullable($value = true);
            $table->date('resedule_from_date3')->nullable($value = true);
            $table->date('resedule_to_date3')->nullable($value = true);
            $table->date('due_date')->nullable($value = true);
            $table->tinyInteger('is_callender')->nullable($value = true);
            $table->tinyInteger('task_status')->nullable($value = true);
            $table->tinyInteger('sl')->nullable($value = true);
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
        Schema::dropIfExists('property_project_timelines');
    }
}

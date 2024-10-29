<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTowerInspectionListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tower_inspection_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('room_name', 200)->nullable($value = true);
            $table->string('inspection_task', 4000)->nullable($value = true);
            $table->Integer('frequench_check')->default(0);
            $table->string('inspection_by', 300)->nullable($value = true);
            $table->string('send_report_to', 300)->nullable($value = true);
            $table->tinyInteger('project_id')->default(0)->index();
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
        Schema::dropIfExists('tower_inspection_lists');
    }
}

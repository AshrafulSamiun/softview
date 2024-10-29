<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('suit_name', 200)->nullable($value = true);
            $table->Integer('floor_name')->default(0)->index();
            $table->tinyInteger('project_id')->default(0)->index();
            $table->tinyInteger('total_rooms')->default(0);
            $table->tinyInteger('one_room')->default(0);
            $table->tinyInteger('two_room')->default(0);
            $table->tinyInteger('three_room')->default(0);
            $table->tinyInteger('town_house')->default(0);

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
        Schema::dropIfExists('suits');
    }
}

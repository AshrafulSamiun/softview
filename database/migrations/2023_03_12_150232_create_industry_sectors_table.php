<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndustrySectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('industry_sectors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sector_name', 400)->nullable($value = true);
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
        Schema::dropIfExists('industry_sectors');
    }
}

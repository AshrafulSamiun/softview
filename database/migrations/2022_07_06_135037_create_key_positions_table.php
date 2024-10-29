<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeyPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('key_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('reference_id')->default(0);
            $table->Integer('project_id')->default(0);
            $table->tinyInteger('page_id')->default(0);
            $table->Integer('master_id')->default(0);

            $table->string('reference_value', 150)->nullable($value = true);
            $table->string('office_phone', 100)->nullable($value = true);
            $table->string('office_mobile', 100)->nullable($value = true);
            $table->string('fax', 100)->nullable($value = true);
            $table->string('key_position_name', 150)->nullable($value = true);
            $table->string('email', 150)->nullable($value = true);


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
        Schema::dropIfExists('key_positions');
    }
}

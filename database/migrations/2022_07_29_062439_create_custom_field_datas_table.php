<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomFieldDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_field_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0);
            $table->Integer('field_id')->default(0);
            $table->Integer('master_id')->default(0);
            $table->tinyInteger('page_id')->default(0);
            $table->tinyInteger('field_type')->default(0);
            $table->string('text', 350)->nullable($value = true);
            $table->Integer('number')->nullable($value = true);
            $table->dateTime('date_time', $precision = 0)->nullable($value = true);

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
        Schema::dropIfExists('custom_field_datas');
    }
}

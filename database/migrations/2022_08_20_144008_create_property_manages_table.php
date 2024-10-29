<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyManagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_manages', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0);
			$table->Integer('moduleId')->default(0);
			$table->Integer('rootMenu')->default(0);
			$table->Integer('position')->default(0);
			$table->Integer('slno')->default(0);
            $table->Integer('user_id')->default(0);
            $table->string('property_manage_name', 200)->nullable($value = true);
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
        Schema::dropIfExists('property_manages');
    }
}

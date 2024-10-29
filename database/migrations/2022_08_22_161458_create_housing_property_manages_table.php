<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHousingPropertyManagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('housing_property_manages', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0);
            $table->Integer('user_id')->default(0);
			$table->Integer('mst_id')->default(0);
			$table->Integer('reference_id')->default(0);
            $table->string('property_manage_by_name', 200)->nullable($value = true);
			$table->string('id_no', 200)->nullable($value = true);
			$table->string('cantact', 200)->nullable($value = true);
			$table->Integer('yes_no')->default(0);
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
        Schema::dropIfExists('housing_property_manages');
    }
}

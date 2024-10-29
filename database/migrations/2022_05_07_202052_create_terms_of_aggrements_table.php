<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTermsOfAggrementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms_of_aggrements', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('diclaration')->default(0)->index();
            $table->string('full_name', 200)->nullable($value = true);
            $table->string('position', 100)->nullable($value = true);
            $table->string('office_phone', 100)->nullable($value = true);
            $table->string('mobile', 100)->nullable($value = true);
            $table->string('email', 100)->nullable($value = true);
            $table->string('location', 200)->nullable($value = true);
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
        Schema::dropIfExists('terms_of_aggrements');
    }
}

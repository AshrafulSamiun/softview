<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('company_logo')->nullable($value = true);
            $table->string('legal_name', 100)->nullable($value = true);
            $table->string('operational_name', 100)->nullable($value = true);
            $table->string('website', 50)->nullable($value = true);


            $table->string('jurisdiction_of_incorporation', 250)->nullable($value = true);
            $table->string('incorporation_number', 100)->nullable($value = true);

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
        Schema::dropIfExists('user_companies');
    }
}

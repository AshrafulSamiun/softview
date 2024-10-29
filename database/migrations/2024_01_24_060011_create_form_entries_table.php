<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('company_id')->default(0)->index();
            $table->tinyInteger('form_type')->nullable($value = true);
            $table->tinyInteger('priority_level')->default(0)->index();
            $table->Integer('system_prefix')->default(0);
            $table->string('form_no', 50)->nullable($value = true);
            $table->date('form_date')->nullable($value = true);
            $table->string('from_department',100)->nullable($value = true);
            $table->string('from_id_name',500)->nullable($value = true);
            $table->string('to_department',200)->nullable($value = true);
            $table->string('to_id_name',200)->nullable($value = true);
            $table->text('subject')->nullable($value = true);
            $table->tinyInteger('posting_status')->default(0);
            $table->tinyInteger('next_step')->default(0);
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
        Schema::dropIfExists('form_entries');
    }
}

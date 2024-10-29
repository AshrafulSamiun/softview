<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcPeriodMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ac_period_masters', function (Blueprint $table) {
           $table->increments('id');
           $table->tinyInteger('project_id')->default(0);
           $table->Integer('year_start')->default(0);
           $table->Integer('company_id')->default(0);
           $table->date('year_start_date');
           $table->date('year_end_date');
           $table->string('period_name',50)->index();
           $table->tinyInteger('is_closed')->default(0);
           $table->tinyInteger('is_current')->default(0);
           $table->tinyInteger('posting_status')->default(0);
           $table->Integer('inserted_by')->default(0);
           $table->Integer('updated_by')->default(0);
           $table->tinyInteger('status_active')->default(1)->index();
           $table->tinyInteger('is_deleted')->default(0)->index();
           $table->tinyInteger('is_locked')->default(0);
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
        Schema::dropIfExists('ac_period_masters');
    }
}

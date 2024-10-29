<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcPeriodDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ac_period_details', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('mst_id')->references('id')->on('ac_period_masters')->onDelete('cascade')->index();
            $table->Integer('month_id')->default(0);
            $table->date('period_starting_date');
            $table->date('period_ending_date');
            $table->string('financial_period',50)->index();
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
        Schema::dropIfExists('ac_period_details');
    }
}

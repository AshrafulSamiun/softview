<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('subgroup_id')->constrained('service_plan_subgroups')->onDelete('restrict')->onUpdate('cascade');
            $table->enum('plan_type', ['Basic', 'Standard', 'Premium', 'Enterprise']);
            $table->double('amount', 10, 2);
           // $table->tinyInteger('slno')->default(0);
            //$table->tinyInteger('rate_applicable')->default(0);
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
        Schema::dropIfExists('service_plans');
    }
}

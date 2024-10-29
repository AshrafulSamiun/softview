<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserServicePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_service_plans', function (Blueprint $table) {
            $table->increments('id');
       
            $table->tinyInteger('project_id')->default(0)->index();
            $table->tinyInteger('service_plan_type')->default(1);
            $table->tinyInteger('single_owner')->default(0);
            $table->tinyInteger('multiple_owner')->default(0);
            $table->tinyInteger('single_owner_multiproperty')->default(0);
            $table->tinyInteger('multiple_owner_multiproperty')->default(0);
            $table->double('monthly_total_single_owner',8,2)->default(0.00);
            $table->double('monthly_total_multiple_owner',8,2)->default(0.00);
            $table->double('monthly_total_multi_building_single_owner',8,2)->default(0.00);
            $table->double('monthly_total_multi_building_multi_owner',8,2)->default(0.00);
            $table->double('yearly_total_single_owner',8,2)->default(0.00);
            $table->double('yearly_total_multiple_owner',8,2)->default(0.00);
            $table->double('yearly_total_multi_building_single_owner',8,2)->default(0.00);
            $table->double('yearly_total_multi_building_multi_owner',8,2)->default(0.00);
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
        Schema::dropIfExists('user_service_plans');
    }
}

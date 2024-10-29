<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserServicePlanDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_service_plan_details', function (Blueprint $table) {
            $table->increments('id');

            $table->tinyInteger('project_id')->default(0)->index();
            $table->tinyInteger('master_id')->default(1);
            $table->tinyInteger('plan_id')->default(0);
            $table->tinyInteger('plan_value')->default(0);
            $table->double('discount_amount',8,2)->default(0.00);
          
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
        Schema::dropIfExists('user_service_plan_details');
    }
}

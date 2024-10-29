<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyAttributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_attributions', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('company_name')->nullable($value = true);
            $table->Integer('customer_name')->nullable($value = true);
            $table->Integer('building_id')->default(0);
            $table->Integer('suite_id')->default(0);
            $table->Integer('unit_id')->default(0);
            $table->Integer('system_prefix')->default(0);
            $table->string('system_no', 50)->nullable($value = true);
                       
            $table->double('suite_size_qty',10,2)->default(0.00);
            $table->double('unit_size_qty',10,2)->default(0.00);
            $table->double('total_supporting_area',10,2)->default(0.00);
            $table->double('total_parking_stall_size',10,2)->default(0.00);
            $table->double('total_bike_stall_size',10,2)->default(0.00);
            $table->double('total_storage_locker_size',10,2)->default(0.00);
            $table->double('mailbox_size_qty',10,2)->default(0.00);
            $table->double('total_common_area',10,2)->default(0.00);
            $table->double('total_property_size_qty',10,2)->default(0.00);

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
        Schema::dropIfExists('property_attributions');
    }
}

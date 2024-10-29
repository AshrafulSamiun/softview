<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupportingRoomDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supporting_room_details', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('master_id')->default(0)->index();
            $table->Integer('floor_id')->default(0)->index();
            $table->Integer('details_id')->nullable($value = true);
            $table->Integer('item_id')->default(0);
            $table->Integer('item_type')->default(0);
            $table->Integer('system_prefix')->default(0);
            $table->string('system_no', 50)->nullable($value = true);
            $table->string('property_name', 100)->nullable($value = true);
            $table->tinyInteger('uom')->nullable($value = true);
            $table->Integer('item_size')->nullable($value = true);
            $table->double('allocated_size',10,2)->default(0.00);
            $table->string('item_name', 250)->nullable($value = true); 
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
        Schema::dropIfExists('supporting_room_details');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExternalServiceProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_service_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->tinyInteger('page_id')->default(0)->index();
            $table->integer('master_id')->nullable($value = true);
            $table->integer('reference_id')->nullable($value = true);
            $table->string('item_name', 150)->nullable($value = true);
            $table->string('id_no', 150)->nullable($value = true);
            $table->string('account_no', 150)->nullable($value = true);
            $table->string('website', 150)->nullable($value = true);
            $table->date('schedule_date')->nullable($value = true);
            $table->date('expected_due_date')->nullable($value = true);
            $table->tinyInteger('billing_cycle')->nullable($value = true);
            $table->tinyInteger('bill_delivery_method')->nullable($value = true);
            $table->tinyInteger('payment_method')->nullable($value = true);
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
        Schema::dropIfExists('external_service_providers');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->string('contact_phone', 100)->nullable($value = true);

            $table->tinyInteger('charging_peroid')->nullable($value = true);
            $table->tinyInteger('currency')->nullable($value = true);
            $table->tinyInteger('business_term')->nullable($value = true);
            $table->tinyInteger('late_payment')->nullable($value = true);
            $table->double('amount_before_tax',8,2)->default(0.00);
            $table->double('reconnection_service_fee',8,2)->default(0.00);
            $table->double('nsf_fee',8,2)->default(0.00);
            $table->date('service_contact_date')->nullable($value = true);
            $table->date('service_request_start_date')->nullable($value = true);
            $table->date('duration')->nullable($value = true);
            $table->date('charging_date')->nullable($value = true);
            $table->date('reconnection_date')->nullable($value = true);
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
        Schema::dropIfExists('service_contacts');
    }
}

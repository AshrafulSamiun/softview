<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('company_id')->default(0)->index();
            $table->tinyInteger('company_type')->default(0)->index();
            $table->Integer('entry_form')->default(0)->index();
            $table->Integer('purchase_type')->default(0)->index();
            $table->Integer('system_prefix')->default(0);
            $table->string('unique_no', 50)->nullable($value = true);
            $table->string('transaction_no', 50)->nullable($value = true);
            $table->Integer('seller_id')->default(0);
            $table->string('seller_account_no', 100)->nullable($value = true);
            $table->Integer('service_provider_id')->default(0);
            $table->string('service_provider_account_no', 100)->nullable($value = true);
            $table->Integer('customer_id')->default(0);
            $table->string('customer_account_no',50)->nullable($value = true);
            $table->string('notification_by',50)->nullable($value = true);
            $table->tinyInteger('backorder_allowed')->nullable($value = true);
            $table->tinyInteger('approval_status')->nullable($value = true);
            $table->tinyInteger('posting_status')->default(0);
            $table->tinyInteger('approve_by')->nullable($value = true);
            $table->date('schedule_delivery_date')->nullable($value = true);
            $table->dateTime('approval_date', $precision = 0);

            $table->string('delivery_location',100)->nullable($value = true);
            $table->string('delivery_instruction',500)->nullable($value = true);
            $table->string('delivery_contact_person_name',200)->nullable($value = true);
            $table->string('delivery_contact_person_email',200)->nullable($value = true);
            $table->string('delivery_contact_person_phone',200)->nullable($value = true);
            $table->string('delivery_receive_by',200)->nullable($value = true);
            $table->date('payment_due_date')->nullable($value = true);
            $table->tinyInteger('days_left_to_pay')->nullable($value = true);
            $table->tinyInteger('early_payment_discount')->nullable($value = true);
            $table->tinyInteger('payment_method')->nullable($value = true);
            $table->tinyInteger('posted_check_available')->nullable($value = true);
            $table->tinyInteger('shipping_cost_pay_by')->nullable($value = true);

            $table->double('late_payment_pelanty',8,2)->default(0.00);
            $table->double('hidden_cost',8,2)->default(0.00);
            $table->tinyInteger('payment_status')->nullable($value = true);
            $table->string('shipping_company_account_no', 100)->nullable($value = true);
            $table->Integer('shipping_company_id')->default(0);
            $table->string('vehicle_identification_number',100)->nullable($value = true);
            $table->string('vehicle_make',100)->nullable($value = true);
            $table->string('vehicle_model',100)->nullable($value = true);
            $table->string('vehicle_year',100)->nullable($value = true);
            $table->tinyInteger('vehicle_type')->nullable($value = true);
            $table->string('vehicle_license_plate',100)->nullable($value = true);
            $table->integer('vehicle_image_id')->default(0);

            $table->string('driver_name',100)->nullable($value = true);
            $table->string('driver_address',100)->nullable($value = true);
            $table->string('driver_license_no',100)->nullable($value = true);
            $table->string('driver_contact_no',100)->nullable($value = true);
            $table->integer('driver_photo_id')->default(0);
            $table->string('vehicle_insurance_information',500)->nullable($value = true);
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
        Schema::dropIfExists('purchases');
    }
}

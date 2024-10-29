<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('page_id')->default(0)->index();
            $table->Integer('system_prefix')->default(0);
            $table->string('system_no', 50)->nullable($value = true);
            $table->string('account_no', 50)->nullable($value = true);
            $table->tinyInteger('scope_of_operation')->nullable($value = true);
            $table->tinyInteger('customer_type')->nullable($value = true);
            $table->integer('company_id')->nullable($value = true);
            $table->tinyInteger('account_status')->nullable($value = true);

            $table->date('status_date')->nullable($value = true);
            $table->string('acount_reason', 4000)->nullable($value = true);
            $table->string('account_comments', 4000)->nullable($value = true);

            $table->string('legal_name', 400)->nullable($value = true);
            $table->string('operational_name', 400)->nullable($value = true);
            $table->string('headoffice_house_number', 150)->nullable($value = true);
            $table->string('headoffice_street_number', 150)->nullable($value = true);
            $table->string('headoffice_city', 150)->nullable($value = true);
            $table->string('headoffice_state', 150)->nullable($value = true);
            $table->Integer('headoffice_country')->default(0);
            $table->string('headoffice_zip_code', 50)->nullable($value = true);

            $table->integer('currency_domestic')->nullable($value = true);
            $table->integer('foreign_corrency_1')->nullable($value = true);
            $table->integer('foreign_corrency_2')->nullable($value = true);
            $table->integer('foreign_corrency_3')->nullable($value = true);
            $table->integer('foreign_corrency_4')->nullable($value = true);
            $table->integer('foreign_corrency_5')->nullable($value = true);


            
            $table->Integer('invoice_term')->nullable($value = true);
            $table->Integer('sales_tax')->nullable($value = true);

            $table->double('credit_limit_daily',16,2)->default(0.00);
            $table->double('credit_limit_weekly',16,2)->default(0.00);
            $table->double('credit_limit_monthly',16,2)->default(0.00);
            $table->double('credit_limit_semi_monthly',16,2)->default(0.00);
            $table->double('credit_limit_yearly',16,2)->default(0.00);
            $table->date('fiscal_year_start_date')->nullable($value = true);
            $table->date('fiscal_year_end_date')->nullable($value = true);
            $table->tinyInteger('fiscal_year_in_calender')->default(0);
            $table->tinyInteger('recuring_cycle')->default(0);
            $table->tinyInteger('sales_on_credit')->default(0);

            $table->tinyInteger('sales_return')->default(0);
            $table->tinyInteger('invoice_pay_off_order_oldest')->default(0);
            $table->tinyInteger('invoice_pay_off_order_newest')->default(0);
            $table->tinyInteger('invoice_pay_off_order_optional')->default(0);
            $table->tinyInteger('accepted_payment_method_cash')->default(0);
            $table->tinyInteger('accepted_payment_method_check')->default(0);
            $table->tinyInteger('accepted_payment_method_credit_card')->default(0);
            $table->tinyInteger('accepted_payment_method_pap')->default(0);

            $table->tinyInteger('accepted_payment_method_dd')->default(0);
            $table->tinyInteger('accepted_payment_method_email')->default(0);
            $table->tinyInteger('invoice_delivery_method_hard_copy')->default(0);
            $table->tinyInteger('invoice_delivery_method_email')->default(0);
            $table->tinyInteger('invoice_delivery_method_both')->default(0);
            $table->tinyInteger('calendr_director')->default(0);
            $table->tinyInteger('calender_accounting_manager')->default(0);
            $table->tinyInteger('calender_building_manager')->default(0);

            $table->tinyInteger('calender_general_manager')->default(0);
            $table->tinyInteger('calender_netwrok_administrator')->default(0);
            $table->tinyInteger('calender_property_manager')->default(0);
            $table->tinyInteger('calender_account_payable')->default(0);
            

           // $table->date('comment_date')->nullable($value = true);


            $table->tinyInteger('comment_calendar')->default(0);
            $table->text('comments')->nullable($value = true);
            $table->timestamp('comment_date');
            
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
        Schema::dropIfExists('customers');
    }
}

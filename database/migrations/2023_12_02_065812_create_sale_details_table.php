<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('master_id')->default(0)->index();
            $table->string('item_name', 150)->nullable($value = true);
            $table->Integer('product_id')->default(0);
            $table->string('item_description', 300)->nullable($value = true);
            $table->Integer('qty')->default(0);
            $table->double('rate',10,2)->default(0.00);
            $table->double('addition',10,2)->default(0.00);
            $table->double('addition_percent',5,2)->default(0.00);
            $table->double('deduction',10,2)->default(0.00);
            $table->double('deduction_percent',5,2)->default(0.00);
            $table->double('sub_total',16,2)->default(0.00);
            $table->double('tax_rate',8,2)->default(0.00);
            $table->double('tax',10,2)->default(0.00);
            $table->double('total',16,2)->default(0.00);
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
        Schema::dropIfExists('sale_details');
    }
}

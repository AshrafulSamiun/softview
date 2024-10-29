<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_types', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->tinyInteger('tax_type')->default(0)->index();
            $table->Integer('system_prefix')->default(0);
            $table->string('system_no', 50)->nullable($value = true);
            $table->string('tin_no', 200)->nullable($value = true);
            $table->string('tax_office_name',150)->nullable($value = true);
            $table->string('tax_office_address',200)->nullable($value = true);
            $table->string('tax_office_contact',200)->nullable($value = true);
            $table->double('tax_rate',5,2)->default(0.00);
            $table->tinyInteger('period_name')->nullable($value = true);
            $table->date('period_start_date')->nullable($value = true);
            $table->date('period_end_date')->nullable($value = true);
            $table->date('period_due_on')->nullable($value = true);
            $table->tinyInteger('period_add_calendar')->nullable($value = true);
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
        Schema::dropIfExists('tax_types');
    }
}

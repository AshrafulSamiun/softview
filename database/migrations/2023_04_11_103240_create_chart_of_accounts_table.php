<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChartOfAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('coa_group')->default(0)->index();
            $table->Integer('sub_group')->default(0)->index();
            $table->Integer('second_level')->default(0)->index();
            $table->Integer('third_level')->default(0)->index();
            $table->Integer('forth_level')->default(0)->index();
            $table->string('account_no', 30)->nullable($value = true);
            $table->string('account_description', 500)->nullable($value = true);
            $table->string('govt_tax_code', 30)->nullable($value = true);
            $table->string('income_tax_code', 30)->nullable($value = true);
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
        Schema::dropIfExists('chart_of_accounts');
    }
}

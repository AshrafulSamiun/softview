<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyGovernmentAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_government_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('reference_id')->default(0);
            $table->Integer('project_id')->default(0);
            $table->tinyInteger('page_id')->default(0);
            $table->Integer('master_id')->default(0);
            $table->string('reference_value', 150)->nullable($value = true);
            $table->string('account_number', 100)->nullable($value = true);
            $table->date('filling_date')->nullable($value = true);
            $table->tinyInteger('filling_cycle')->default(0);
            $table->tinyInteger('is_callender')->default(0);
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
        Schema::dropIfExists('company_government_accounts');
    }
}

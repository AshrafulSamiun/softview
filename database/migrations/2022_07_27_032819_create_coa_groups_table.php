<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoaGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coa_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('reference_id')->default(0);
            $table->Integer('main_level')->default(0)->index();
            $table->Integer('sub_level')->default(0)->index();
            $table->Integer('third_level')->default(0)->index();
            $table->Integer('forth_level')->default(0)->index();

            $table->double('opening_balance',16,2)->default(0.00);
            $table->Integer('from')->nullable($value = true);
            $table->Integer('to')->nullable($value = true);
            $table->string('account_title', 200)->nullable($value = true);
            $table->tinyInteger('active')->default(0);
            $table->tinyInteger('statement_type')->default(0);
            $table->tinyInteger('income_statement')->default(0);
            $table->tinyInteger('balance_sheet')->default(0);
            $table->tinyInteger('retained_earning')->default(0);
            $table->tinyInteger('transaction_type')->default(0); 
            $table->tinyInteger('balance_type')->default(0);  
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
        Schema::dropIfExists('coa_groups');
    }
}

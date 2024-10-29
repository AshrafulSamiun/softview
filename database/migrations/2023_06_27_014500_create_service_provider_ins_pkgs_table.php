<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceProviderInsPkgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_provider_ins_pkgs', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('master_id')->default(0)->index();
            $table->tinyInteger('reference_id')->nullable($value = true);
            $table->string('item_name',150)->nullable($value = true);
            $table->string('company_name',150)->nullable($value = true);
            $table->string('address',250)->nullable($value = true);
            $table->string('policy_no',100)->nullable($value = true);
            $table->date('expire_date')->nullable($value = true);
            $table->string('max_coverage',150)->nullable($value = true);
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
        Schema::dropIfExists('service_provider_ins_pkgs');
    }
}

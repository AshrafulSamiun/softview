<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnerOthorizePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owner_othorize_people', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->Integer('project_id')->default(0)->index();
            $table->string('fm_legal_name', 100)->nullable($value = true);
            $table->string('fm_address', 200)->nullable($value = true);
            $table->Integer('fm_photo_id')->nullable($value = true);
            $table->Integer('fm_gove_id_fontpart')->nullable($value = true);
            $table->Integer('fm_gove_id_backpart')->nullable($value = true);

            $table->string('relation_with_landlord', 150)->nullable($value = true);;
            $table->string('fm_office_phone', 50)->nullable($value = true);
            $table->string('fm_cell_phone', 50)->nullable($value = true);
            $table->string('fm_email', 100)->nullable($value = true);
            $table->string('fm_company_name', 100)->nullable($value = true);
            $table->string('fm_company_phone', 100)->nullable($value = true);
            $table->string('business_address', 200)->nullable($value = true);
            $table->string('fm_company_bn_no', 100)->nullable($value = true);
            $table->string('fm_company_website', 100)->nullable($value = true);
            
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
        Schema::dropIfExists('owner_othorize_people');
    }
}

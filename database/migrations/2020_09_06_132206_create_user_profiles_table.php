<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('project_id')->default(0)->index();
            $table->Integer('user_id')->default(0)->index();
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable($value = true);
            $table->string('last_name', 100)->nullable($value = true);
            $table->string('nick_name', 100)->nullable($value = true);

            $table->string('website', 130)->nullable($value = true);

            $table->string('office_phone', 100)->nullable($value = true);
            $table->string('cell_phone', 100)->nullable($value = true);
            $table->string('home_phone', 100)->nullable($value = true);
            $table->string('official_email', 130)->nullable($value = true);
            $table->string('recovery_email', 130)->nullable($value = true);
            $table->Integer('user_type');
            $table->integer('user_photo_id')->nullable($value = true);
            $table->string('country_id',20)->nullable($value = true);
            $table->string('billing_country_id',20)->nullable($value = true);
            $table->string('mailing_country_id',20)->nullable($value = true);

            $table->string('state', 100)->nullable($value = true);
            $table->string('mailing_state', 100)->nullable($value = true);
            $table->string('billing_state', 100)->nullable($value = true);

            $table->string('city', 100)->nullable($value = true);
            $table->string('mailing_city', 100)->nullable($value = true);
            $table->string('billing_city', 100)->nullable($value = true);

            $table->string('street', 100)->nullable($value = true);
            $table->string('mailing_street', 100)->nullable($value = true);
            $table->string('billing_street', 100)->nullable($value = true);

            $table->string('postal_code', 50)->nullable($value = true);
            $table->string('mailing_postal_code', 50)->nullable($value = true);
            $table->string('billing_postal_code', 50)->nullable($value = true);
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
        Schema::dropIfExists('user_profiles');
    }
}

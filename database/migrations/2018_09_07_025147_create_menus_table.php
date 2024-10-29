<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('moduleId');
            $table->tinyInteger('project_id')->default(1)->index();
            $table->integer('rootMenu')->default(0);
            $table->string('menuName',200)->nullable($value = true);
            $table->string('menuRoute',200)->nullable($value = true);
            $table->integer('status')->default(1);
            $table->integer('position')->default(0);
            $table->integer('slno')->default(0);
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
        Schema::dropIfExists('menus');
    }
}

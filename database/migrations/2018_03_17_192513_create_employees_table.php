<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',255);
            $table->string('last_name',255);
            $table->string('middle_name',255)->nullable();
            $table->integer('position_id')->unsigned();
            $table->string('avatar',255)->nullable();
            $table->date('employment_date');
            $table->integer('director_id')->unsigned()->nullable();
            $table->integer('wage')->unsigned()->default(1000);
            $table->timestamps();
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('director_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign(['director_id']);
        });
        Schema::dropIfExists('employees');
    }
}

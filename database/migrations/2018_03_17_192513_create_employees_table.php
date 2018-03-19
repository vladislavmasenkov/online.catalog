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
            $table->integer('position')->unsigned();
            $table->string('avatar',255)->nullable();
            $table->date('employment_date');
            $table->integer('director')->unsigned()->nullable();
            $table->timestamps();
        });
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('director')->references('id')->on('employees');
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
            $table->dropForeign(['director']);
        });
        Schema::dropIfExists('employees');
    }
}

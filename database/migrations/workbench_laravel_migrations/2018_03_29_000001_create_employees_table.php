<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'employees';

    /**
     * Run the migrations.
     * @table employees
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->unsignedInteger('position_id');
            $table->string('avatar')->nullable();
            $table->date('employment_date')->nullable();
            $table->unsignedInteger('director_id')->nullable();
            $table->unsignedInteger('wage')->default('1000');

            $table->index(["director_id"], 'employees_director_id_foreign_idx');

            $table->index(["position_id"], 'employees_position_id_foreign_idx');


            $table->foreign('director_id', 'employees_director_id_foreign_idx')
                ->references('id')->on('employees')
                ->onDelete('restrict')
                ->onUpdate('no action');

            $table->foreign('position_id', 'employees_position_id_foreign_idx')
                ->references('id')->on('positions')
                ->onDelete('restrict')
                ->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}

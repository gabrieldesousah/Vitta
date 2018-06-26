<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('cpf', 255)->nullable();
            $table->string('rg', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->date('born')->nullable();
            $table->date('date_exam')->nullable();
            $table->string('token')->nullable();
            $table->integer('token_expire')->nullable();

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
        Schema::dropIfExists('pacientes');
    }
}

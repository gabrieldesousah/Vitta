<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbordagensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abordagens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unidade_id')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->string('patient_name', 255)->nullable();
            $table->string('cpf', 255)->nullable();
            $table->string('rg', 255)->nullable();
            $table->integer('origem')->nullable();
            $table->integer('medico_id')->nullable();
            $table->string('medico_name', 255)->nullable();
            $table->string('pedido_exame', 255)->nullable();
            $table->string('valor_orcado', 255)->nullable();
            $table->string('venda', 255)->nullable();
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
        Schema::dropIfExists('abordagens');
    }
}

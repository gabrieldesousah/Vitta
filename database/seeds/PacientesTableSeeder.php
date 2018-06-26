<?php

use Illuminate\Database\Seeder;

class PacientesTableSeeder extends Seeder
{
    public function run()
    {
      //Queremos criar de 5 a 10 respostas por tópico
    	//O laravel cria uma collection com o seguinte script:
    	$pacientes = factory(\App\Paciente::class, 50)->create();
    	//Agora posso entrar no collection como se fosse um array:
    	$pacientes->each(function($paciente) {
    	  factory(\App\exames_resultados::class, rand(5,10))->create(['paciente_id' => $paciente->id]);
    	});
    }
}

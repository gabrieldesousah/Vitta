<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use TANIOS\Airtable\Airtable;

class GenteGestaoController extends Controller
{
	public function __construct()
    {
        //$this->middleware('auth');
    }
    
    public function colaboradores(){

		$airtable = new Airtable(array(
		    'api_key'   => 'keyyQI5fROPrZ7QZF',
		    'base'      => 'appRSXoEylxhvJ61B',
		));

		$request = $airtable->getContent( 'Colaboradores', 
		[
			'sort'  => [
		    [ 
		       'field'  => 'Nome',
		       'direction'  => 'desc'
		    ]  
		  ]
		] );

		$i = 0;

 		do {
		    $response = $request->getResponse();
		    $records = $response[ 'records' ];

		    foreach ( $records as $record ) {
			    $dias[$i] = array(
			    	'Nome' => $record->fields->Nome ?? null,
			    	'Foto' => $record->fields->Foto[0]->url ?? null,
			    	'Situação' => $record->fields->Situação ?? null,
			    	'Tipo' => $record->fields->Tipo ?? null,
			    	'ScoreAtual' => $record->fields->ScoreAtual ?? null,
			    	'TipoDeContrato' => $record->fields->TipoDeContrato[0] ?? null,
			    	'TotalDeFaltas' => $record->fields->TotalDeFaltas ?? null,
			    	'RequisiçõesAprovadasVittalecas' => $record->fields->RequisiçõesAprovadasVittalecas ?? null,
			    	'EstadoCivil' => $record->fields->EstadoCivil ?? null,
			    	'Unidade' => $record->fields->Unidade[0] ?? null,
			    	'HistóricoSetores' => $record->fields->HistóricoSetores[0] ?? null,
			    	'DataMáximaParaFérias' => $record->fields->DataMáximaParaFérias ?? null,
			    );
			    $i++;
			}

		}
		while( $request = $response->next() );

		return($dias);
    }

}
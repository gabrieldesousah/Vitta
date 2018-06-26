<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use TANIOS\Airtable\Airtable;

class ProdutosController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){

		$airtable = new Airtable(array(
		    'api_key'   => 'keyyQI5fROPrZ7QZF',
		    'base'      => 'appRSXoEylxhvJ61B',
		));

		$request = $airtable->getContent( 'Cat%C3%A1logo%20Vittalecas', 
		[
			'sort'  => [
		    [ 
		       'field'  => 'Vittalecas',
		       'direction'  => 'asc'
		    ]  
		  ]
		] );

		$responseA = $request->getResponse();
		$request = $responseA->next();
		$responseB = $request->getResponse();

		$r[0] = $responseA;
		$r[1] = $responseB;
 		/*
 		do {
		    $response = $request->getResponse();
		    var_dump( $response[ 'records' ] );
		}
		while( $request = $response->next() );
	*/
		//dd($responseA);
		//dd($responseB);

		return view('produtos.index', [
			"request" => $r,
		  "title"		=> "Vittalecas"

		]);
    }

    public function show( $id ){
    	$airtable = new Airtable(array(
		    'api_key'   => 'keyyQI5fROPrZ7QZF',
		    'base'      => 'appRSXoEylxhvJ61B',
		    'title'			=> 'Vittalecas'
			));

			$request = $airtable->getContent( 'Cat%C3%A1logo%20Vittalecas/'.$id );
			$produto = $request->getResponse();

			$request = $airtable->getContent( 'Colaboradores/' . Auth::user()->airtable_id );
	        $user = $request->getResponse();

			return view('produtos.show', [
				"produto" => $produto,
				"user" => $user,
			  "title"		=> "Vittalecas"
			]);
    }

    public function trocar( $id ){
    	$airtable = new Airtable(array(
		    'api_key'   => 'keyyQI5fROPrZ7QZF',
		    'base'      => 'appRSXoEylxhvJ61B',
		));

		$request = $airtable->getContent( 'Cat%C3%A1logo%20Vittalecas/'.$id );
		$produto = $request->getResponse();

		$request = $airtable->getContent( 'Colaboradores/' . Auth::user()->airtable_id );
        $user = $request->getResponse();

        date_default_timezone_set('UTC');;
        
        if( ($user->fields->ScoreAtual - $produto->fields->Vittalecas) >= 0  
            and date("d") > 5 
            and date("d") <= 10 
        ){
        
	    	$date = date("d/m/Y");
			$new_request_details = array
			(
			    'Data'        	=> $date,
			    'Colaborador' 	=> [Auth::user()->airtable_id],
			    'Produto' 		=> [$id],
			    'Status'       	=> 'Aguardando',
		    	'title'			=> 'Vittalecas'
			);

			// Save to Airtable
			$new_request = $airtable->saveContent( "Requisi%C3%A7%C3%B5es%20de%20Compra%20Vittalecas", $new_request_details );
        }else{
        	return redirect('/produto/'.$id)->with('status', "Ocorreu um erro. Avise seu gestor por favor.");;
        }

        return redirect('/home')->with('status', "Troca de ".$produto->fields->Vittalecas." Vittalecas solicitada com sucesso.");
    }
}

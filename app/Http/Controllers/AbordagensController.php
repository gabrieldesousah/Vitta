<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Abordagens;

use TANIOS\Airtable\Airtable;
use Auth;

class AbordagensController extends Controller
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

			$request = $airtable->getContent( 'Colaboradores',
			[
				'sort'  => [
			    [ 
			       'field'  => 'Nome',
			       'direction'  => 'asc'
			    ]  
			  ],
			  "filterByFormula" => "AND( Tipo = 'Médico' )"
			] );

			$response = $request->getResponse();
			$medicos = $response["records"];


    	return view('os/abordagens', ['medicos' => $medicos]);
    }

    public function store(Request $request){

    	$airtable = new Airtable(array(
          'api_key'   => 'keyyQI5fROPrZ7QZF',
          'base'      => 'appRSXoEylxhvJ61B',
      ));

      $request = $airtable->getContent( 'Contacts' );

      //dd(Auth::user()->airtable_id);
      $expended = $airtable->getContent( 'Colaboradores/'.Auth::user()->airtable_id, false, [
          'RequisiçõesDeCompraVittalecas'      => [
              'table'         => 'Requisi%C3%A7%C3%B5es%20de%20Compra%20Vittalecas',
              'relations'     => [
                  'Produto'  => 'Cat%C3%A1logo%20Vittalecas',
              ]
          ],
          'Contratações'      => 'Contrata%C3%A7%C3%B5es',
          'Score' => 'Score',
          'ScoreMédicoLink' => 'Score%20M%C3%A9dicos',
      ]);
      $user = $expended->getResponse();

    	$abordagem = new Abordagens;

    	$abordagem->user_id	 = $user->fields->Unidade[0];
    	$abordagem->user_id	 = auth()->user()->id;
    	$abordagem->patient_name = $request->input("name");
    	$abordagem->cpf = $request->input("rg");
    	$abordagem->rg = $request->input("cpf");
    	$abordagem->origem = $request->input("origem");
    	$abordagem->medico_name = $request->input("medico");
    	$abordagem->pedido_exame = $request->input("pedido_exame");
    	$abordagem->valor_orcado = $request->input("valor_orcado");
    	$abordagem->venda = $request->input("venda") ?? "false";

    	if( $abordagem->save() ){
    		return redirect('/falcao/abordagens')->with('status', 'Confirmado');
    	}

   		return redirect()->back()->with('status', 'Erro');

    }
}

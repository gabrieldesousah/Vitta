<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use TANIOS\Airtable\Airtable;

class UsersController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index( $detalhes = false )
    {
    		if( $detalhes )
        {
            if ($detalhes == "medicos"){
                $filter = "AND( Tipo = 'Médico' )";
                $detalhes = "Médicos";
            }elseif ($detalhes == "colaboradores") {
                $filter = "AND( Tipo = 'Colaborador' )";   
                $detalhes = "Colaboradores";  
            }else{
                $filter = "";
            }
        }else{
        	$filter = "";
        	$detalhes = "Equipe";
        }

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
			  "filterByFormula" => $filter
			] );

			$response = $request->getResponse();
			$users = $response["records"];

			return view('colaboradores.index', [
				'users' => $users,
				'detalhes' => $detalhes
			]);

    }

    public function show( $id ){
    	$airtable = new Airtable(array(
		    'api_key'   => 'keyyQI5fROPrZ7QZF',
		
		    'base'      => 'appRSXoEylxhvJ61B',
		));


		$request = $airtable->getContent('Colaboradores/' . $id);

		$user = $request->getResponse();

		return view('colaboradores.show', ["user" => $user]);
    }
}

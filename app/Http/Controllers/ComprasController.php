<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use TANIOS\Airtable\Airtable;

class ComprasController extends Controller
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

		$request = $airtable->getContent( 'Cat%C3%A1logo%20Vittalecas' );

		$response = $request->getResponse();
		//dd($response);

		return view('produtos.index', ["produtos" => $response['records']]);
    }

}

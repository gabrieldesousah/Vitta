<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use TANIOS\Airtable\Airtable;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Auth::user()->airtable_id == null ){
            return redirect( '/airtable' );
        }
        
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

        //dd($user);
        return view('home', ["user" => $user]);
    }
}

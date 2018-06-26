<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

use TANIOS\Airtable\Airtable;

class AirtableController extends Controller
{
    public function index(){
		$airtable = new Airtable(array(
		    'api_key'   => 'keyyQI5fROPrZ7QZF',
		    'base'      => 'appRSXoEylxhvJ61B',
		));

		$request = $airtable->getContent( 'Colaboradores' );

		$response = $request->getResponse();

		$user = new User();
		$user = $user->find(Auth::user()->id);

		foreach( $response['records'] as $record ){
			if(isset($record->fields->Nome) and $record->fields->Nome == Auth::user()->name)
			{
				//echo $record->id;
				$user->airtable_id = $record->id;
			}
			elseif( 
				isset($record->fields->EmailCorporativo) and $record->fields->EmailCorporativo == Auth::user()->email
			){
				//echo $record->id;
				$user->airtable_id = $record->id;
			}
			elseif(
				isset($record->fields->EmailPessoal) and $record->fields->EmailPessoal == Auth::user()->email
			){
				//echo $record->id;
				$user->airtable_id = $record->id;
			}
		}

		$user->save();
		return redirect('/dashboard');
    }
}

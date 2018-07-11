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

			$user = Auth::user();

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

			if( $user->airtable_id == null ){
				echo "
				<h1>
					Seus dados não foram encontrados... você precisa preencher esse formulário: 
					<br>
					<a href='https://airtable.com/shr1Rq8YgNsekwJu2'>Cadastro de colaboradores</a>
					<br><br>
					<a href='https://airtable.com/shrs9BETcpqwpakuj'>Cadastro de médicos</a>

					<br><br>
					E colocar os mesmos dados no login.
				</h1>
				";
				die();
			}

			$user->save();
			return redirect('/dashboard');
    }
}

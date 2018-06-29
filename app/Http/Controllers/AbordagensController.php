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

      $airt = $airtable->getContent( 'Contacts' );

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

    	$abordagem->unidade	 = $user->fields->Unidade[0];
    	$abordagem->user_id	 = auth()->user()->id;
    	$abordagem->patient_name = $request->input("name");
    	$abordagem->cpf = $request->input("rg");
    	$abordagem->rg = $request->input("cpf");
      $abordagem->medico_name = $request->input("medico");
    	$abordagem->origem = $request->input("origem");
    	$abordagem->pedido_exame = $request->input("pedido_exame");
    	$abordagem->valor_orcado = $request->input("valor_orcado");
    	$abordagem->venda = $request->input("venda") ?? "false";

    	if( $abordagem->save() ){
    		return redirect('/falcao/abordagens')->with('status', 'Confirmado');
    	}

   		return redirect()->back()->with('status', 'Erro');

    }

    public function dados( $now = false, $unidade = false)
    {
        $hour_start = $_GET["hour_start"] ?? "00:00";
        $hour_end = $_GET["hour_end"] ?? "23:59";
        
        $unidade = isset($unidade) ? $unidade : ($_GET["unidade"] ?? 'Centro');
        // dd($unidade);
        if( $now != false || isset($_GET["now"]) ){
            date_default_timezone_set("America/Sao_Paulo");
            $date_start = date('Y-m-d H:i', abs(strtotime(date('H:i')) - 60*15));
            $date_end = date('Y-m-d H:i');
            
            $abordagens = abordagens::where([
                ['unidade', '=', $unidade],
                ['created_at', '>=', $date_start],
                ['created_at', '<', $date_end]
            ])
            ->orderBy('user_id')
            ->orderBy('valor_orcado')
            ->get();

            date_default_timezone_set("UTC");
            $now = true;
        }
        elseif( isset($_GET["today"]) ){
          $date_start = date('Y-m-d') . ' 00:00:00';   
            $date_end = date('Y-m-d') . ' 23:59:59';
            
            $abordagens = abordagens::where([
                ['unidade', '=', $unidade],
                ['created_at', '>=', $date_start],
                ['created_at', '<', $date_end]
            ])
            ->orderBy('user_id')
            ->orderBy('valor_orcado')
            ->get();
        }
        else 
        {
            $abordagens = abordagens::orderBy('user_id')
            ->orderBy('valor_orcado')
            ->get();
        }


        return view('os.dados', [
          "abordagens" => $abordagens,
        ]);
    }
}

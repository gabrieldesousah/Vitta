<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Abordagens;
use App\User;

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
        if( isset($_GET["date_start"]) ){
            date_default_timezone_set("America/Sao_Paulo");
            $date_start = $_GET["date_start"] . " " . $hour_start;
            $date_end = $_GET["date_end"] . " " . $hour_end;

            $unidade = $_GET["unidade"] ?? null;
            $origem = $_GET["origem"] ?? null;
            
            $abordagens = abordagens::where([
                ['created_at', '>=', $date_start],
                ['created_at', '<', $date_end]
            ])
            ->orderBy('created_at')
            ->orderBy('user_id')
            ->orderBy('valor_orcado')
            ->get();

            if( $unidade != null ){
              $abordagens = $abordagens->where('unidade', $unidade);
            }

            if( $origem != null ){
              $abordagens = $abordagens->where('origem', $origem);
            }

            // dd($_GET["unidade"]);
            // dd($_GET["origem"]);
            // dd($date_start);
            // dd($date_end);

            date_default_timezone_set("UTC");
        }
        elseif( isset($_GET["today"]) ){
          $date_start = date('Y-m-d') . ' 00:00:00';   
            $date_end = date('Y-m-d') . ' 23:59:59';
            
            $abordagens = abordagens::where([
                ['unidade', '=', $unidade],
                ['created_at', '>=', $date_start],
                ['created_at', '<', $date_end]
            ])
            ->orderBy('created_at')
            ->orderBy('user_id')
            ->orderBy('valor_orcado')
            ->get();
        }
        else 
        {
            $abordagens = abordagens::orderBy('created_at')
            ->orderBy('user_id')
            ->orderBy('valor_orcado')
            ->get();
        }

        $users = $abordagens->groupBy('user_id')->toArray();

        return view('os.dados', [
          "abordagens" => $abordagens,
          "users" => $users
        ]);
    }

    public function exportar(){
      $dadosA = abordagens::orderBy('created_at')
        ->orderBy('user_id')
        ->orderBy('valor_orcado')
        ->get();

      header("Content-Transfer-Encoding: utf-8");
      header("Content-type: text/csv; charset=utf-8");
      header("Content-Disposition: attachment; filename=file.csv");
      header("Pragma: no-cache");
      header("Expires: 0");

      echo "id".";". "unidade".";"."user_id".";"."patient_name".";"."cpf".";"."rg".";"."origem".";"."medico_name".";"."pedido_exame".";"."valor_orcado".";"."venda".";"."created_at" ."
          ";
      foreach($dadosA as $dados)
      {
          echo $dados->id.";".$dados->unidade.";".$dados->user_id.";".utf8_decode($dados->patient_name).";".$dados->cpf.";".$dados->rg.";".$dados->origem.";".utf8_decode($dados->medico_name).";".$dados->pedido_exame.";".$dados->valor_orcado.";".$dados->venda.";".$dados->created_at ."
          ";
      }
      // return $dados;
    }
}

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

    	$abordagem->user_id	 = $user->fields->Unidade[0];
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
        
        $unidade = ($unidade == true) ? $unidade : ($_GET["unidade"] ?? null);
        // dd($unidade);
        if( $now != false || isset($_GET["now"]) ){
            date_default_timezone_set("America/Sao_Paulo");
            $date_start = date('Y-m-d H:i', abs(strtotime(date('H:i')) - 60*15));
            $date_end = date('Y-m-d H:i');
            
            $abordagens = abordagens::where([
                ['unidade_id', '=', $unidade],
                ['created_at', '>=', $date_start],
                ['created_at', '<', $date_end]
            ])
            ->orderBy('user_id')
            ->get(['user_id', 'origem', 'medico_name', 'pedido_exame', 'valor_orcado', 'venda']);

            date_default_timezone_set("UTC");
            $now = true;
        }
        elseif( isset($_GET["today"]) ){
          $date_start = date('Y-m-d') . ' 00:00:00';   
            $date_end = date('Y-m-d') . ' 23:59:59';
            
            $abordagens = abordagens::where([
                ['unidade_id', '=', $unidade],
                ['created_at', '>=', $date_start],
                ['created_at', '<', $date_end]
            ])
            ->orderBy('user_id')
            ->get(['user_id', 'origem', 'medico_name', 'pedido_exame', 'valor_orcado', 'venda']);
        }
        else 
        {
          if( isset($_GET["date_start"]) ){
               $date_start = $_GET["date_start"] . " " . $hour_start;
               $date_end = $_GET["date_end"] . " " . $hour_end;
               
               $hour_start = $hour_start;
               $hour_end = $hour_end;
            }else{
                $date_start = date('Y-m-d') . ' 00:00';   
                $date_end = date('Y-m-d') . ' 23:59';
                $hour_start = null;
                $hour_end = null;    
            }
            $abordagens = abordagens::where([
                ['unidade_id', '=', $unidade],
                ['created_at', '>=', $date_start],
                ['created_at', '<=', $date_end]
            ])
            ->orderBy('user_id')
            ->get(['user_id', 'origem', 'medico_name', 'pedido_exame', 'valor_orcado', 'venda']);
        }

        dd($abordagens);

        $tmacollect_medio = $tmacollect_medio->sort()->values();

        //Dividir em quartis:
        $quantidade_por_quartil = floor($tmacollect_medio->count()/4);
        // dd($quantidade_por_quartil);
        $slice1 = $tmacollect_medio->slice(0, $quantidade_por_quartil);
        $slice2 = $tmacollect_medio->slice($quantidade_por_quartil, $quantidade_por_quartil);
        $slice3 = $tmacollect_medio->slice($quantidade_por_quartil*2, $quantidade_por_quartil);
        $slice4 = $tmacollect_medio->slice($quantidade_por_quartil*3, $quantidade_por_quartil);

        $piores_tempos = $tmacollect_medio->sortKeysDesc()->slice(0, 5);

        return view('bi.triagem', [
          "piores_tempos" => $piores_tempos,
          "tmacollect" => $tmacollect_medio,
            "unidade" => $unidade,
          "servico" => $servico,
          "now" => $now,
          "slice1" => $slice1,
          "slice2" => $slice2,
          "slice3" => $slice3,
          "slice4" => $slice4,
            "faixa07" => $grouped->get('07') ? $grouped->get('07')->avg() : null,
            "faixa08" => $grouped->get('08') ? $grouped->get('08')->avg() : null,
            "faixa09" => $grouped->get('09') ? $grouped->get('09')->avg() : null,
            "faixa10" => $grouped->get('10') ? $grouped->get('10')->avg() : null,
            "faixa11" => $grouped->get('11') ? $grouped->get('11')->avg() : null,
            "faixa12" => $grouped->get('12') ? $grouped->get('12')->avg() : null,
            "faixa13" => $grouped->get('13') ? $grouped->get('13')->avg() : null,
            "faixa14" => $grouped->get('14') ? $grouped->get('14')->avg() : null,
            "faixa15" => $grouped->get('15') ? $grouped->get('15')->avg() : null,
            "faixa16" => $grouped->get('16') ? $grouped->get('16')->avg() : null,
            "faixa17" => $grouped->get('17') ? $grouped->get('17')->avg() : null,
            "faixa18" => $grouped->get('18') ? $grouped->get('18')->avg() : null,
            "faixa19" => $grouped->get('19') ? $grouped->get('19')->avg() : null,
            "qtd_porfaixa07" => $grouped->get('07') ? $grouped->get('07')->count() : 0,
            "qtd_porfaixa08" => $grouped->get('08') ? $grouped->get('08')->count() : 0,
            "qtd_porfaixa09" => $grouped->get('09') ? $grouped->get('09')->count() : 0,
            "qtd_porfaixa10" => $grouped->get('10') ? $grouped->get('10')->count() : 0,
            "qtd_porfaixa11" => $grouped->get('11') ? $grouped->get('11')->count() : 0,
            "qtd_porfaixa12" => $grouped->get('12') ? $grouped->get('12')->count() : 0,
            "qtd_porfaixa13" => $grouped->get('13') ? $grouped->get('13')->count() : 0,
            "qtd_porfaixa14" => $grouped->get('14') ? $grouped->get('14')->count() : 0,
            "qtd_porfaixa15" => $grouped->get('15') ? $grouped->get('15')->count() : 0,
            "qtd_porfaixa16" => $grouped->get('16') ? $grouped->get('16')->count() : 0,
            "qtd_porfaixa17" => $grouped->get('17') ? $grouped->get('17')->count() : 0,
            "qtd_porfaixa18" => $grouped->get('18') ? $grouped->get('18')->count() : 0,
            "qtd_porfaixa19" => $grouped->get('19') ? $grouped->get('19')->count() : 0,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\historico_atendimentos_triagem;
use App\atendimentos;
use Illuminate\Http\Request;

class BiController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function triagem( $now = false, $unidade = false, $servico = false )
    {
        $servico = $_GET["servico"] ?? $servico;
        $hour_start = $_GET["hour_start"] ?? "00:00";
        $hour_end = $_GET["hour_end"] ?? "23:59";
        
        $caixa = array(8, 9, 12);
        $recepcao  = array(5, 7, 2, 11, 1, 6);
        if( $servico )
        {
            if ($servico == "recepcao"){
                $servico_ids = $recepcao;     
            }elseif ($servico == "caixa") {
                $servico_ids = $caixa;     
            }else{
                $servico = false;
            }
        }


        $unidade = ($unidade == true) ? $unidade : ($_GET["unidade"] ?? 1);
        // dd($unidade);
        if( $now != false || isset($_GET["now"]) ){
            date_default_timezone_set("America/Sao_Paulo");
            $date_start = date('Y-m-d H:i', abs(strtotime(date('H:i')) - 60*15));
            $date_end = date('Y-m-d H:i');
            
            $triagens = atendimentos::where([
                ['unidade_id', '=', $unidade],
                ['dt_cheg', '>=', $date_start],
                ['dt_cheg', '<', $date_end]
            ])
            ->get(['servico_id', 'usuario_id', 'dt_cheg', 'dt_cha']);

            date_default_timezone_set("UTC");
            $now = true;
        }
        elseif( isset($_GET["today"]) ){
        	$date_start = date('Y-m-d') . ' 00:00:00';   
            $date_end = date('Y-m-d') . ' 23:59:59';
            
            $triagens = atendimentos::where([
                ['unidade_id', '=', $unidade],
                ['dt_cheg', '>=', $date_start],
                ['dt_cheg', '<', $date_end]
            ])
            ->get(['servico_id', 'usuario_id', 'dt_cheg', 'dt_cha']);
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
            $triagens = historico_atendimentos_triagem::where([
            	['unidade_id', '=', $unidade],
                ['dt_cheg', '>=', $date_start],
                ['dt_cheg', '<=', $date_end]
            ])
            ->get(['servico_id', 'usuario_id', 'dt_cheg', 'dt_cha']);
        }

        if( $servico ){
            $triagens = $triagens->whereIn('servico_id', $servico_ids);
        }

        $data = [];
        $tmacollect = collect();
        $tmacollect_medio = collect();
        foreach ($triagens as $i => $triagem) {
            $triagem_dt_cha = strtotime($triagem->dt_cha);
            $triagem_dt_cheg = strtotime($triagem->dt_cheg);
            $tma = $triagem_dt_cha - $triagem_dt_cheg;
            // dd($tma);
            // dd(date('H', $tma));
            if( date('H', $tma) == '0' && date('i', $tma) < '40' ){
                if( '7' <= date('H', $triagem_dt_cheg) && date('H', $triagem_dt_cheg) < '20'){
                    // dd($triagem_dt_cha);
                    // dd(date('d', $triagem_dt_cha));
                    $data[$i] = $triagem;
                    $data[$i]["ano"] = date('Y', $triagem_dt_cheg);
                    $data[$i]["mes"] = date('m', $triagem_dt_cheg);
                    $data[$i]["dia"] = date('d', $triagem_dt_cheg);
                    $data[$i]["hora"] = date('H', $triagem_dt_cheg);
                    $data[$i]["dt_cha"] = $triagem_dt_cha;
                    $data[$i]["dt_cheg"] = $triagem_dt_cheg;
                    $data[$i]["tma"] = date('H:i', $triagem_dt_cha - $triagem_dt_cheg);

                    $tma_time = $triagem_dt_cha - $triagem_dt_cheg;
            		
                    $tma = [
                        'time' => $tma_time,
                        'faixa' => date('H', $triagem_dt_cheg),
                    ];

                    $tmacollect->prepend($tma);
            		$tmacollect_medio->prepend($tma_time);    
                    $i++;
                    // dd($tmacollect);
                }
            }
        }
        $grouped = $tmacollect->mapToGroups(function ($item, $key) {
            return [$item['faixa'] => $item['time']];
        });
        // dd($tmacollect);
        // dd($grouped);

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

    public function triagem_gera_excel()
    {
        //dd(strtotime('00:40:00'));

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=dados.csv");
        header("Pragma: no-cache");
        header("Expires: 0");

        $triagens = historico_atendimentos_triagem::select(
            'unidade_id',
            'dt_cheg',
            'dt_cha'
        )->get();
        //dd(strtotime($triagem_dt_cha) - strtotime($triagem_dt_cheg));
        $data = [];
        foreach ($triagens as $i => $triagem) {
            //dd($triagem_dt_cha);
            $triagem_dt_cha = strtotime($triagem->dt_cha);
            $triagem_dt_cheg = strtotime($triagem->dt_cheg);
            $tma = $triagem_dt_cha - $triagem_dt_cheg;
            if( date('H', $tma) == '0' && date('i', $tma) < '40' ){
                if( '7' < date('H', $triagem_dt_cheg) && date('H', $triagem_dt_cheg) < '20'){
                    //dd($triagem_dt_cha);
                    //dd(date('d', $triagem_dt_cha));
                    $data[$i] = $triagem;
                    $data[$i]["ano"] = date('Y', $triagem_dt_cheg);
                    $data[$i]["mes"] = date('m', $triagem_dt_cheg);
                    $data[$i]["dia"] = date('d', $triagem_dt_cheg);
                    $data[$i]["hora"] = date('H', $triagem_dt_cheg);
                    $data[$i]["dt_cha"] = $triagem_dt_cha;
                    $data[$i]["dt_cheg"] = $triagem_dt_cheg;
                    $data[$i]["tma"] = date('H:i', $triagem_dt_cha - $triagem_dt_cheg);


                    echo "\"".$data[$i]["ano"]."\";";
                    echo "\"".$data[$i]["mes"]."\";";
                    echo "\"".$data[$i]["dia"]."\";";
                    echo "\"".$data[$i]["hora"]."\";";
                    echo "\"".$data[$i]["dt_cha"]."\";";
                    echo "\"".$data[$i]["dt_cheg"]."\";";
                    echo "\"".$data[$i]["tma"]."\";";
                    echo "
";
    
                    $i++;
                }
            }
        }
        //return $data;
    }
}

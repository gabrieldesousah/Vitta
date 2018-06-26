<?php

namespace App\Http\Controllers;

use App\exames_resultados;
use App\Paciente;
use Illuminate\Http\Request;

class ResultadosController extends Controller
{
    public function __construct(){
        ini_set('max_execution_time', '2000');
    }

    public function index(){
        return view('pacientes.index');
    }
    
    public function HermesPardiniAuth()
    {
        $login='13527';
        $senha='4113';
        $url_base='https://www.hermespardini.com.br';
        $url=$url_base.'/scripts/mgwms32.dll?MGWLPN=HPHOSTBS&App=RESTRACK';

        $tmpfname = base_path().DIRECTORY_SEPARATOR.'storage/app/public/'.'Authorization.txt';
        var_dump($tmpfname);
        $credentials = $login.":".$senha; 

        $headers = array(
            "Authorization: Basic ".base64_encode($credentials),
        ); 

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL,$url); 
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $tmpfname);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $tmpfname);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
        $page = curl_exec($ch);
        curl_close($ch);

        return "Auth ok";
    }

    public function getPatients()
    {
        $login = $_POST["login"] ?? '13527';
        $senha = $_POST["password"] ?? '4113';

        $timei = strtotime('-6days');
        $timef = strtotime(date('H:i'))-60*60*24*0;


        $DATI = date('Y-m-d 00:00:00', $timei );
        $DATF = date('Y-m-d 23:59:59', $timef );

        $pacientes = Paciente::where([
            ['updated_at', '>=', $DATI],
            ['updated_at', '<=', $DATF]
        ])->get();

        if( $pacientes->count() == 0 ){
	      echo "Nenhum paciente encontrado na nossa base de dados nesse período de {$DATI} e {$DATF}";
        }

        foreach ($pacientes as $key => $paciente) {

            $DATI = ($paciente->date_exam != null)? date('d/m/Y', strtotime($paciente->date_exam)) : date('d/m/Y', $timei); 
            $DATF = ($paciente->date_exam != null) ? date('d/m/Y', strtotime($paciente->date_exam) + 60*60*24*10) : date('d/m/Y', $timef); 

            $DATI = urlencode($DATI);
            $DATF = urlencode($DATF);

            $this->HermesPardiniGet($login, $senha, $DATI, $DATF, urlencode($paciente->name), $paciente);
        }
        echo "<h3>Caso nenhum resultado apareça, experimente acessar a página novamente</h3>";

    }

    public function HermesPardiniGet($login, $senha, $DATI = null, $DATF = null, $name = null, $paciente = null)
    {
        $url_base='https://www.hermespardini.com.br';

        /////////////////////////////////////////////////////////////////////////////
        //NA VDD, É PRECISO PRIMEIRO CONSULTAR O NOME DO PACIENTE PARA SALVAR NO BD//
        /////////////////////////////////////////////////////////////////////////////

        if( $DATI != null && $DATF != null &&  $name != null ){
            $url=$url_base.'/scripts/mgwms32.dll?MGWLPN=HPHOSTBS&App=RESTRACK&UND=58&SUBMIT=ok&DATI='.$DATI.'&DATF='.$DATF.'&NCLI='.$name;
        }
        elseif( $DATI != null && $DATF != null ){
            $url=$url_base.'/scripts/mgwms32.dll?MGWLPN=HPHOSTBS&App=RESTRACK&UND=58&SUBMIT=ok&DATI='.$DATI.'&DATF='.$DATF;
        }
        elseif( $name != null ){
            $name = urlencode($name);
            $url=$url_base.'/scripts/mgwms32.dll?MGWLPN=HPHOSTBS&App=RESTRACK&UND=58&SUBMIT=ok&NCLI='.$name;
        }
        else{
            $DATI = urlencode( date('d/m/y', strtotime(date('H:i'))-60*60*24*6) );
            $DATF = urlencode( date('d/m/y', strtotime(date('H:i'))-60*60*24*3) );

            $url=$url_base.'/scripts/mgwms32.dll?MGWLPN=HPHOSTBS&App=RESTRACK&UND=58&SUBMIT=ok&DATI='.$DATI.'&DATF='.$DATF;
        }

        // dd( $name );
        // dd( $url );
        $tmpfname = base_path().DIRECTORY_SEPARATOR.'storage/app/public/'.'Authorization.txt';
        $credentials = $login.":".$senha; 

        $headers = array(
            "Authorization: Basic ".base64_encode($credentials),
        ); 

        $page = $this->HermesPardiniRequest($url, $login, $senha, $tmpfname, $headers);

        $regex = '/onClick=\"return qs\(this\)\;\" HREF=\"(.*?)\"\>/';

        $h = null;
        $i = 0;
        // echo "<pre>";
        // var_dump($url);
        // echo "<br><br>";
        if ( preg_match_all($regex, $page, $list, PREG_SET_ORDER ) ){
            foreach ($list as $key => $l) {
                // print_r($list);
                if(strrpos($l[1], 'PED') != 0){
                    if( $h != $l[1] ){
                        $resultado = $url_base.$l[1]."&PPREVIEW=1&formatoPDF=1&TIMBRADOPED=0";
                        
                        $regex = '/&PED=(.*?)&/';
                        preg_match($regex, $resultado, $ped);

                        $regex = '/&ANOPED=(.*?)&/';
                        preg_match($regex, $resultado, $anoped);
                        
                        $page = $this->HermesPardiniRequest($resultado, $login, $senha, $tmpfname, $headers);

                        $paciente_id = $paciente->id ?? 0;

                        $arquivo_destino = base_path().DIRECTORY_SEPARATOR.'storage/app/public/resultados'.DIRECTORY_SEPARATOR. $paciente_id . '-'.'HP'.'-'.$ped[1].'-'.$anoped[1].'.pdf';
                        $arquivo = fopen($arquivo_destino, "a+");
                        
                        if( $paciente != null )
                        {
	                        if( fwrite($arquivo, $page) )
	                        {
	                        	//Salva no banco de dados
	                        	$exames_resultados = exames_resultados::where("ped", $ped[1])->first();
	                        	if( $exames_resultados == null ){
	                        		$exames_resultados = new exames_resultados;
		                        	$exames_resultados->paciente_id = $paciente->id ?? null;
		                        	$exames_resultados->laboratory = "HP" ?? null;
		                        	$exames_resultados->path_file = 
		                        		'storage/app/public/resultados'.
		                        		DIRECTORY_SEPARATOR.
		                        		$paciente_id.
		                        		'-'.'HP'.'-'.
		                        		$ped[1].'-'.$anoped[1].'.pdf';

		                        	$exames_resultados->ped = $ped[1] ?? null;
		                        	$exames_resultados->anoped = $anoped[1] ?? null;

		                        	$exames_resultados->save();
            									
            						echo "cadastro do exame {$ped[1]} realizado com sucesso";
                                    echo "<br>";

	                        	}
	                        	else
	                        	{
	                        		echo "Exame {$ped[1]} já cadastrado [Paciente {$name}]";
                                    echo "<br>";
	                        	}
	                        }
	                        else
	                        {
	                        	echo "Erro para escrever o arquivo";
                                echo "<br>";
	                        }
                        }
                        else
                        {
                        	echo "Paciente [{$name}] inexistente";
                            echo "<br>";
                        }
                        fclose($arquivo);
                        // sleep(1);

                        // echo "<br><br>";
                    }
                    $h = $l[1];
                }
                $i++;
            }
        }
        else{
            // echo "Expressão regex não bateu com o site. Contate o suporte";
            echo "<b>Nenhum resultado encontrado para o [Paciente {$name}]</b>";
            echo "<br>"; 
        }
    }

    public function HermesPardiniRequest($url, $login, $senha, $tmpfname, $headers){
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL,$url); 
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $tmpfname);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $tmpfname);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
        $page = curl_exec($ch);
        curl_close($ch);

        return $page;
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\exames_resultados  $exames_resultados
     * @return \Illuminate\Http\Response
     */
    public function edit(exames_resultados $exames_resultados)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\exames_resultados  $exames_resultados
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, exames_resultados $exames_resultados)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\exames_resultados  $exames_resultados
     * @return \Illuminate\Http\Response
     */
    public function destroy(exames_resultados $exames_resultados)
    {
        //
    }
}

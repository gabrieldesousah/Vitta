<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ordens_servico;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ordens_servicoController extends Controller
{
    public $colunasAceitas = array(
        "Nro" => ["Nro", "nro"],
        "Paciente"  => ["Paciente", "paciente"],
        "Status" => ["Status", "status"],
        "Tratamento" => ["Tratamento", "tratamento"],
        "Data" => ["Data", "data"],
        "Valor_Total"	=> ["Valor Total", "valortotal"],//ignora os espacos
        "Pago" => ["Pago", "pago"],
        "Saldo" => ["Saldo", "saldo"],
        "Usuario" => ["Usuário", "usuario", "Usuario", "usurio"],
        "Unidade" => ["Unidade", "unidade"],
        "ignorar" => []
    );

    public function index(){
      ini_set('max_execution_time', '600');

    	$rota = "";

      $error=null;
      $pastaTemporaria = base_path('storage/app/tmp/');
      //$pastaTemporaria = dirname(__FILE__).DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR;
      $time = time();
        
      /////Se existe algum arquivo sendo enviado ao servidor
      if(count($_FILES) && isset($_FILES['file']) && $_FILES['file']['error']==0)
      {

          try{
              $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($_FILES['file']['tmp_name']);
              $ext = explode('.',$_FILES['file']['name']);
              $ext = strtolower( end($ext) );
              if(empty($ext)){
                  throw new Exception("Arquivo inv&aacute;lido.");
              }
              $writer = new Xlsx($spreadsheet);
              $writer->save($pastaTemporaria.$time.'.'.($ext));

              if(file_exists($pastaTemporaria.$time.'.'.($ext))){
                  $dados = $spreadsheet->getActiveSheet()->toArray();
                  if(!empty($dados)){

                      header("Location: ".$rota."?f=".$time.'&e='.($ext));/////////////////---------------Para evitar duplicidade de arquivo
                      exit;
                  }else{
                      throw new Exception("Arquivo n&atilde;o aceito.");
                  }
              }else{
                  throw new Exception("Arquivo n&atilde;o suportado ou corrompido.");
              }
          }catch(Exception $e){
              $erro = $e->getMessage();
          }
      }
      else if(isset($_GET['f'])&&!empty($_GET['f']))
      {
          $time = preg_replace("%[^0-9]%","",$_GET['f']);
          $ext = preg_replace("%[^0-9a-z]%","",$_GET['e']);
          if(file_exists($pastaTemporaria.$time.'.'.$ext))
          {
              $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($pastaTemporaria.$time.'.'.$ext);
              $dados = $spreadsheet->getActiveSheet()->toArray();
              $colunas = [];
              $colunasNaoConhecidas = [];


              if(count($_POST)&&isset($_POST['tipo'])&&is_array($_POST['tipo'])){
                  foreach($_POST['tipo'] as $i=>$tipo){
                      if(empty($tipo)){
                          $this->colunasAceitas['ignorar'][] = $_POST['val'][$i];
                      }else
                      if(isset($this->colunasAceitas[$tipo])){
                          $this->colunasAceitas[$tipo][] = $_POST['val'][$i];
                      }
                  }
              }


              foreach($dados[0] as $coluna){
                  $tipo = $this->tipoColuna($coluna,$this->colunasAceitas);
                  if($tipo===null&&!empty($coluna)){
                      $colunasNaoConhecidas[]=$coluna;
                  }
                  $colunas[] = ["type"=>$tipo,"value"=>$coluna];
              }

              if(!empty($colunasNaoConhecidas)){
                  unset($this->colunasAceitas['ignorar']);

                  return view('os.verify',[
                    'colunasNaoConhecidas' => $colunasNaoConhecidas,
                    'colunasAceitas'  => $this->colunasAceitas
                  ]);
                  exit;
              }else{
              	
                  $clientes = array();
                  $numeros = array();
                  $emails = array();
                  unset($dados[0]);

                  $resposta = array();
                  ///alimenta o array $clientes
                  foreach($dados as $k=>$dado)
                  {
                      $clientes[$k] = array();

                      foreach($colunas as $i=>$coluna)
                      {
                          if($coluna['type']=='ignorar')
                              continue;
                          if($coluna['type']=='phone'){
                              $phone = $this->trataTelefone( $dado[$i],$ddd,$ddi );
                              if(!isset($numeros[$phone])&&!empty($phone)){
                                  $numeros[$phone]=true;
                                  $clientes[$k][$coluna['type']][] = $phone;
                              }
                          }elseif($coluna['type']=='Data')
                              $clientes[$k][$coluna['type']] = $this->trataData( $dado[$i] );
                          elseif($coluna['type']=='email'){
                              $email = $this->trataEmail( $dado[$i] );
                              if(!empty($email) && !isset($emails[$email]))
                                  $clientes[$k][$coluna['type']][] = $email;
                          }
                          elseif($coluna['type']=='cpf')
                              $clientes[$k][$coluna['type']] = $this->trataCPFCNPJ( $dado[$i] );
                          elseif($coluna['type']=='cnpj')
                              $clientes[$k][$coluna['type']] = $this->trataCPFCNPJ( $dado[$i] );
                          elseif($coluna['type']=='rg')
                              $clientes[$k][$coluna['type']] = preg_replace('%[^0-9]%','', $dado[$i] );
                          else
                              $clientes[$k][$coluna['type']] = preg_replace('%[^0-9a-zA-Z\ \.\-\+\/,\(\)\[\]\{\}&;:]%iUs','',htmlentities($dado[$i]));
                      }
                  }

                  echo "<pre>";
                  foreach ($clientes as $key => $cliente)
                  {
	                  	var_dump($cliente);
                      // $contact = new campaign_contacts;
                      // $contact->name = $cliente["name"] ?? null;
                      // $contact->phone = $cliente["phone"][0] ?? null;
                      // $contact->email = $cliente["email"][0] ?? null;
                      // $contact->company = $cliente["company"] ?? null;
                      // $contact->branch_company = $cliente["ramo"] ?? null;
                      // $contact->born = $cliente["nascimento"] ?? null;
                      // $contact->rg = $cliente["rg"] ?? null;
                      // $contact->cpf = $cliente["cpf"] ?? null;
                      // $contact->cnpj = $cliente["cnpj"] ?? null;
                      // $contact->instagram = $cliente["instagram"] ?? null;
                      // $contact->twitter = $cliente["twitter"] ?? null;
                      // $contact->site = $cliente["site"] ?? null;       

                      // $contact->campaign_id = $campaign->id;
                      // $contact->customer_id = $campaign->customer_id;

                      // if(strlen($contact->phone) < 12){
                      //   echo($contact->phone . "Errado");
                      // }

                      // if($contact->name != null || $contact->phone != null || $contact->email != null){
                      //     if($contact->save()){
                      //       // dd($contact);
                      //       $resposta[$key]["name"] = $contact->name;
                      //       $resposta[$key]["phone"] = $contact->phone;
                      //       $resposta[$key]["success"] = true;
                      //     }else{
                      //       $resposta[$key]["name"] = $contact->name;
                      //       $resposta[$key]["phone"] = $contact->phone;
                      //       $resposta[$key]["success"] = false;
                      //     }
                      // }

                  }
                  // return redirect('campaigns/'.$campaign->customer_id.'/'.$campaign->id)->with("reply", $resposta);
                  exit;
              }

              
          }else{
              header("Location: /os");
              exit;
          }
      }
 
      return view('os.planilha', [
        'error' => $error
      ]);

    }

    public function tipoColuna($value,$colunasAceitas)
    {
        $value = preg_replace("%[^0-9a-zA-Z]%iUs","",strtolower($value));
        foreach($colunasAceitas as $tipo=>$col){
            if(in_array($value,$col)){
                return $tipo;
            }
        }
        return null;
    }

    public function trataData($value){
        if(preg_match('%([\/|\-])%iUs', $value,$resultado)){
            $delimitador = $resultado[0];
            $partes = explode($delimitador, $value);
            if(sizeof($partes)==3){
                $data = implode('-',array_reverse($partes));
                $data = strtotime($data . " 00:00:00");

                return date('Y-m-d', $data);
                //return implode('-',array_reverse($partes));
            }
            return null;
        }
        $value = preg_replace("%[^0-9]%","",$value);
        if(!empty($value))
            return date('Y-m-d',strtotime('1900-1-1 00:00:00 +'.$value.'days'));
        else
            return null;
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use TANIOS\Airtable\Airtable;

class DadosDiariosController extends Controller
{
	public function __construct()
    {
        //$this->middleware('auth');
    }
    
    public function backoffice(){

		$airtable = new Airtable(array(
		    'api_key'   => 'keyyQI5fROPrZ7QZF',
		    'base'      => 'appxSGD4Yz6KV04Xb',
		));

		$request = $airtable->getContent( 'Back%20Office', 
		[
			'sort'  => [
		    [ 
		       'field'  => 'Data',
		       'direction'  => 'desc'
		    ]  
		  ]
		] );

		$i = 0;

 		do {
		    $response = $request->getResponse();
		    $records = $response[ 'records' ];

		    foreach ( $records as $record ) {
			    $dias[$i] = array(
			    	'Data' => $record->fields->Data ?? null,
			    	'PCE' => $record->fields->TicketMédioPCE ?? null,
			    	'Compras Diárias' => $record->fields->ComprasDiárias ?? null,
			    	'QuebraDiária' => $record->fields->QuebraDiária ?? null,
			    	'NúmeroDeConsultas' => $record->fields->NúmeroDeConsultas ?? null,
			    	'CartãoDeCrédito' => $record->fields->CartãoDeCrédito ?? null,
			    	'CartãoDeDébito' => $record->fields->CartãoDeDébito ?? null,
			    	'Dinheiro' => $record->fields->Dinheiro ?? null,
			    	'Desconto' => $record->fields->Desconto ?? null,
			    	'Repasse' => $record->fields->Repasse ?? null,
			    	'FechamentoDiário' => $record->fields->FechamentoDiário,
			    	'Mês' => $record->fields->Mês,
			    	'Ano' => $record->fields->Ano,
			    	'DiaDaSemana' => $record->fields->DiaDaSemana,
			    	'FechamentoProporcional' => $record->fields->FechamentoProporcional ?? null,
			    	'TicketMédioPonderado' => $record->fields->TicketMédioPonderado ?? null,
			    	'MetaAlcançada' => $record->fields->MetaAlcançada ?? null
			    );
			    $i++;
			}

		}
		while( $request = $response->next() );

		return($dias);
    }

    public function recepcao(){
    	$airtable = new Airtable(array(
		    'api_key'   => 'keyyQI5fROPrZ7QZF',
		    'base'      => 'appxSGD4Yz6KV04Xb',
		));

		$request = $airtable->getContent( 'Recep%C3%A7%C3%A3o', 
		[
			'sort'  => [
		    [ 
		       'field'  => 'Data',
		       'direction'  => 'desc'
		    ]  
		  ]
		] );

		$i = 0;

 		do {
		    $response = $request->getResponse();
		    $records = $response[ 'records' ];

		    foreach ( $records as $record ) {
			    $dias[$i] = array(
			    	'Data' => $record->fields->Data,
			    	'PacotesVendidos' => $record->fields->PacotesVendidos ?? null,
			    	'ConsultasCruzadas' => $record->fields->ConsultasCruzadas ?? null,
			    	'OrçamentosFechados' => $record->fields->OrçamentosFechados ?? null,
			    	'FalcãoPacientesAbordados' => $record->fields->FalcãoPacientesAbordados ?? null,
			    	'OrçamentoDeCirurgias' => $record->fields->OrçamentoDeCirurgias ?? null,
			    	'DescriçãoCirurgia' => $record->fields->DescriçãoCirurgia ?? null
			    );
			    $i++;
			}

		}
		while( $request = $response->next() );

		return($dias);
    }

    public function enfermagem(){
    	$airtable = new Airtable(array(
		    'api_key'   => 'keyyQI5fROPrZ7QZF',
		    'base'      => 'appxSGD4Yz6KV04Xb',
		));

		$request = $airtable->getContent( 'Enfermagem', 
		[
			'sort'  => [
		    [ 
		       'field'  => 'Data',
		       'direction'  => 'desc'
		    ]  
		  ]
		] );

		$i = 0;

 		do {
		    $response = $request->getResponse();
		    $records = $response[ 'records' ];

		    foreach ( $records as $record ) {
			    $dias[$i] = array(
			    	'Data' => $record->fields->Data,		    	
			    	'VacânciaManhãSalasVazias' => $record->fields->VacânciaManhãSalasVazias ?? null,		    	
			    	'VacânicaTardeSalasVazias' => $record->fields->VacânicaTardeSalasVazias ?? null,		    	
			    	'VacânciaPorcentagemManhã' => $record->fields->VacânciaPorcentagemManhã ?? null,		    	
			    	'VacânciaPorcentagemTarde' => $record->fields->VacânciaPorcentagemTarde ?? null	    	
			    );
			    $i++;
			}

		}
		while( $request = $response->next() );

		return($dias);
    }

    public function laboratorio(){
    	$airtable = new Airtable(array(
		    'api_key'   => 'keyyQI5fROPrZ7QZF',
		    'base'      => 'appxSGD4Yz6KV04Xb',
		));

		$request = $airtable->getContent( 'Laborat%C3%B3rio', 
		[
			'sort'  => [
		    [ 
		       'field'  => 'Data',
		       'direction'  => 'desc'
		    ]  
		  ]
		] );

		$i = 0;

 		do {
		    $response = $request->getResponse();
		    $records = $response[ 'records' ];

		    foreach ( $records as $record ) {
			    $dias[$i] = array(
			    	'Data' => $record->fields->Data,  	
			    	'Faturamento' => $record->fields->Faturamento,  	
			    	'ColetasTotais' => $record->fields->ColetasTotais,  	
			    	'ErrosTotal' => isset($record->fields->ErrosTotal) ? $record->fields->ErrosTotal : null,  	
			    	'ErrosDescrição' => isset($record->fields->ErrosDescrição) ? $record->fields->ErrosDescrição : null,  	
			    	'OrçamentosAumentados' => isset($record->fields->OrçamentosAumentados) ? $record->fields->OrçamentosAumentados : null,  	
			    	'OrçamentosAumentadosDescrição' => isset($record->fields->OrçamentosAumentadosDescrição) ? $record->fields->OrçamentosAumentados : null,  	
			    );
			    $i++;
			}

		}
		while( $request = $response->next() );

		return($dias);
    }

    public function callcenter(){
    	$airtable = new Airtable(array(
		    'api_key'   => 'keyyQI5fROPrZ7QZF',
		    'base'      => 'appRN1lJQ0se6nbe1',
		));

		$request = $airtable->getContent( 'Dados', 
		[
			'sort'  => [
		    [ 
		       'field'  => 'Data',
		       'direction'  => 'desc'
		    ]  
		  ]
		] );

		$i = 0;

 		do {
		    $response = $request->getResponse();
		    $records = $response[ 'records' ];

		    foreach ( $records as $record ) {
			    $dias[$i] = array(
			    	'Data' => $record->fields->Data,
			    	'Mês' => $record->fields->Mês,
			    	'Ano' => $record->fields->Ano,
			    	'ConversãoGeral' => $record->fields->ConversãoGeral ?? null,
			    	'PacientesEsperadosCentro' => $record->fields->PacientesEsperadosCentro ?? null,
			    	'PacientesVieramCentro' => $record->fields->PacientesVieramCentro ?? null,
			    	'ComparecimentoCentro' => $record->fields->ComparecimentoCentro ?? null,
			    	'PacientesEsperadosBuriti' => $record->fields->PacientesEsperadosBuriti ?? null,
			    	'PacientesVieramBuriti' => $record->fields->PacientesVieramBuriti ?? null,
			    	'ComparecimentoBuriti' => $record->fields->ComparecimentoBuriti ?? null,
			    	'PacotesCentro' => $record->fields->PacotesCentro ?? null,
			    	'PacotesBuriti' => $record->fields->PacotesBuriti ?? null,
			    	'NúmeroTotalDeLigações' => $record->fields->NúmeroTotalDeLigações ?? null,
			    	'AgendamentoCentro' => $record->fields->AgendamentoCentro ?? null,
			    	'AgendamentoBuriti' => $record->fields->AgendamentoBuriti ?? null,
			    	'RetornosAgendadosCentro' => $record->fields->RetornosAgendadosCentro ?? null,
			    	'RetornosAgendadosBuriti' => $record->fields->RetornosAgendadosBuriti ?? null,
			    	'ChamadasPerdidas' => $record->fields->ChamadasPerdidas ?? null,
			    	'ChamadasPerdidasPorcentagem' => $record->fields->ChamadasPerdidasPorcentagem ?? null,
			    	'SLA' => $record->fields->SLA ?? null,
			    	'AgendamentosCallCenter' => $record->fields->AgendamentosCallCenter ?? null,
			    	
			    );
			    $i++;
			}

		}
		while( $request = $response->next() );

		return($dias);
    }
}
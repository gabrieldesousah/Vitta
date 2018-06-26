<?php
namespace App\Http\Controllers;

use App\Orcamento;
use App\Exames;
use Illuminate\Http\Request;

use Auth;

use TANIOS\Airtable\Airtable;

class OrcamentoController extends Controller
{
    public function create()
    {
        $airtable = new Airtable(array(
            'api_key'   => 'keyyQI5fROPrZ7QZF',
            'base'      => 'appRSXoEylxhvJ61B',
        ));

        $request = $airtable->getContent( 'Contacts' );


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

        if(!Auth::check()){
            return redirect("/login");
        }
        
        $exames = new Exames();
        $exames = $exames->orderBy('nome')->get();
        //dd($exames);
        return view('orcamento.index',[
            //->with("teste", null)
            'exames' => $exames,
            'orcamento' => null,
            'nome' => null,
            "user" => $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exames = new Exames();
        $exames = $exames->all();
        
        
        if(isset($_POST["exames"])){
            $orcamento = "";
            
            foreach($request->input("exames") as $exame){
                $orcamento .= $exame . ", ";
            }
            
            $registro = new Orcamento();
            $registro->user_id   = Auth::user()->id;
            
            if( $request->input("nome") != "" ){
                $registro->nome = $request->input("nome");
            } else {
                $registro->nome = "Orçamento sem nome";
            }
            
            $registro->orcamento = $orcamento;
            
            $registro->save();
            
            $username = $request->old('nome');
            
            return redirect('/orcamento')
            ->with('exames', $exames)
            ->withInput();
        
        }else{
            return redirect('/orcamento')
            ->with('orcamento', null)
            ->with('exames', $exames)
            ->withInput();
        }
    }
}

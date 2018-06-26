<?php

namespace App\Http\Controllers;

use App\Exames;
use Illuminate\Http\Request;

use Auth;

class ExamesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::check()){
            return redirect("/");
        }
        
        return view('exames.create')->with('status', null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(isset($_POST["nome"])){
            $exames = new Exames($request->all());

            if($exames->save()){
                return redirect('/exames')->with('status', 'Exame adicionado com sucesso!');
            }            

        }else{
            return view('exames.create')->with('status', null);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exames  $Exames
     * @return \Illuminate\Http\Response
     */
    public function show(Exames $Exames)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exames  $Exames
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exame = Exames::where('id', $id)->get();

        return view('exames.edit', [
            'exame' => $exame[0]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exames  $Exames
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exames $exame)
    {
        $exame = Exames::where('id', $request->id);
        $exame->update([
            'local' => $request->local,
            'nome'  => $request->nome,
            'categoria' => $request->categoria,
            'preco_final' => $request->preco_final,
            'preco_vitta' => $request->preco_vitta,
            'preco_parceiro'  => $request->preco_parceiro,
            'obs'             => $request->obs
        ]);
        
        return redirect('/exame/'.$request->id)->with('status', 'Exame editado');
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exames  $Exames
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exames $exame)
    {
        $exame->delete();
        return redirect('orcamento');
    }
}

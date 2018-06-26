<?php

namespace App\Http\Controllers;

use App\exames_resultados;
use App\Paciente;
use Illuminate\Http\Request;

class PacientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pacientes.auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pacientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cpf = preg_replace('/[^0-9]/', '', $request->input('cpf'));
        $rg  = preg_replace('/[^0-9]/', '', $request->input('rg'));

        $paciente = Paciente::where([
            ['cpf', '<>', null],
            ['cpf', $cpf],
        ])->first();
        if( $paciente != null )
        {
            $paciente = Paciente::where([
                ['rg', '<>', null],
                ['rg', $rg],
            ])->first();

            if( $paciente != null )
            {
                $paciente->name = strtoupper($this->tirarAcentos(preg_replace("/[^A-zÀ-ú ]/",'',$request->input('name')))) ?? $paciente->name;
                $paciente->phone = preg_replace('/[^0-9]/', '', $request->input('phone')) ?? $paciente->phone;
                $paciente->born = $request->input('born');
                $paciente->cpf = $cpf ?? $paciente->cpf;
                $paciente->rg = $rg ?? $paciente->rg;

                $paciente->date_exam = $request->input('date_exam');
                // $paciente->password = md5($request->input('password'));

                if( $paciente->save() ){
                    return redirect('pacientes/create')->with('status', 'Paciente atualizado.');
                }else{
                    return back()->withInput();
                }
            }
            else
            {
                $paciente = new Paciente;
                $paciente->name = strtoupper($this->tirarAcentos(preg_replace("/[^A-zÀ-ú ]/",'',$request->input('name'))));
                $paciente->phone = preg_replace('/[^0-9]/', '', $request->input('phone'));
                $paciente->born = $request->input('born');
                $paciente->cpf = $cpf;
                $paciente->rg = $rg;
                $paciente->password = md5($request->input('password'));

                $paciente->date_exam = $request->input('date_exam');

                if( $paciente->save() ){
                    return redirect('pacientes/create')->with('status', 'Paciente cadastrado com sucesso.');
                }else{
                    return back()->withInput();
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function auth(Request $request)
    {
        $document = $request->input('document');
        $password = $request->input('password');
        
        $paciente = Paciente::where('cpf', $document)->orWhere('rg', $document)->first();

        if( $paciente == null ){
            return redirect('/resultados')->with('status', "Não foi encontrado nenhum registro com o documento: ".$document);
        }
        if( md5( $password ) == $paciente->password ){
        // dd("Cheguei aqui");
            $paciente->token = md5(time());
            $paciente->token_expire = time()+60*15;
            $paciente->save();

            return redirect('/resultados/get/'.$paciente->id.'?token='.$paciente->token);
        }
        else
        {
            return redirect('/resultados')->with('status', "Senha incorreta para o documento: ".$document);
        }
    }
    public function show(Paciente $paciente)
    {
        if ( $paciente->token == $_GET["token"] ){
            if ( $paciente->token_expire >= time() ){

                $paciente->token_expire = time()+60*15;
                $paciente->save();

                $exames = exames_resultados::where('paciente_id', $paciente->id)->get();

                return view('pacientes.home', [
                    'exames' => $exames
                ]);
            }
            else {
                print("Token expirado");
                return redirect('/resultados')->with('status', 'Tempo de sessão expirado');
            }
        }
        else
        {
            return redirect('/resultados')->with('status', 'Token inválido');
        }
    }

    public function show_file(exames_resultados $ped)
    {
        $paciente = Paciente::where('token', $_GET["token"])->first();

        if ( $paciente->token_expire >= time() ){

            $paciente->token_expire = time()+60*15;
            $paciente->save();
            // dd($ped);

            return view('pacientes.view_file', [
                'exam' => $ped
            ]);
        }
        else {
            print("Token expirado");
            return redirect('/resultados')->with('status', 'Tempo de sessão expirado');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function edit(Paciente $paciente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paciente $paciente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paciente $paciente)
    {
        //
    }

    public function tirarAcentos($string){
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
    }
}

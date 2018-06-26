@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Seus dados</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    @if(isset($user->fields->Foto))
                      <div class="col-lg-4">
                        <img src="{{ $user->fields->Foto[0]->url }}" style="width: 200px;"> <br>
                      </div>
                    @endif

                    <div class="col-lg-8"> 
                        @if(isset($user->fields->Nome))
                            <b>{{ $user->fields->Nome }}</b> <br>
                        @endif

                        @if(isset($user->fields->Telefone))
                            <b>Telefone:</b> {{ $user->fields->Telefone }} <br>
                        @endif

                        @if(isset($user->fields->Endereço))
                            <b>Endereço:</b> {{ $user->fields->Endereço }} <br>
                        @endif

                        <br>

                        @if(isset($user->fields->Unidade))
                            <b>Unidade:</b>
                            @foreach($user->fields->Unidade as $unidade)
                                {{ $unidade }};
                            @endforeach
                            <br>
                        @endif

                        @if(isset($user->fields->Função))
                            <b>Função:</b> {{ $user->fields->Função[0] }}
                            <br>
                        @endif

                        @if(isset($user->fields->Função))
                            <b>Setor:</b> {{ $user->fields->HistóricoSetores[0] }}
                            <br>
                        @endif

                        @if(isset($user->fields->EmailPessoal))
                            <b>Email Pessoal:</b> {{ $user->fields->EmailPessoal }}
                            <br>
                        @endif
                        @if(isset($user->fields->EmailCorporativo))
                            <b>Email Corporativo:</b> {{ $user->fields->EmailCorporativo }}
                            <br>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if( isset($user->fields->Função[0]) && $user->fields->Função[0] == "Administração" )
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Administração Vittá</div>

                <div class="panel-body">

                    <div class="col-lg-4">
                        <b>Triagem</b>

                        <a href="{{ url('triagem/now/1/recepcao') }}" class="btn btn-primary btn-custom">Independência</a>
                        <a href="{{ url('triagem/now/2/recepcao') }}" class="btn btn-primary btn-custom">Buriti</a>
                    </div>

                    <div class="col-lg-4">
                        <b>Time</b>

                        <a href="{{ url('equipe/colaboradores') }}" class="btn btn-primary btn-custom">Equipe</a>
                        <a href="{{ url('equipe/medicos') }}" class="btn btn-primary btn-custom">Médicos</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif 

    @if( isset($user->fields->Função[0]) && ( $user->fields->Função[0] == "Administração" ||  $user->fields->Função[0] == "Recepção" ||  $user->fields->Função[0] == "Falcão" ))
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Falcão</div>

                <div class="panel-body">

                    <div class="col-lg-4">
                        <b>Abordagens</b>

                        <a href="{{ url('falcao/abordagens') }}" class="btn btn-primary btn-custom" target="_blank">Realizar abordagens</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if( isset($user->fields->Função[0]) && ( $user->fields->Função[0] == "Administração" ||  $user->fields->Função[0] == "Laboratório" ))
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Laboratório</div>

                <div class="panel-body">

                    <div class="col-lg-4">
                        <b>Cadastro de pacientes</b>

                        <a href="{{ url('pacientes') }}" class="btn btn-primary btn-custom" target="_blank">Cadastro de pacientes</a>
                    </div>

                    <div class="col-lg-4">
                        <b>Buscar Resultados</b>

                        <a href="{{ url('buscarresultados') }}" class="btn btn-primary btn-custom" target="_blank">Buscar Resultados</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif

    @if( isset($user->fields->Função[0]) && ( $user->fields->Função[0] == "Administração" ||  $user->fields->Função[0] == "Call Center " ))
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Call Center </div>

                <div class="panel-body">

                    <div class="col-lg-4">
                        <b>Orçamentos</b>

                        <a href="{{ url('orcamento') }}" class="btn btn-primary btn-custom">Fazer Orçamento</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif

    @if( isset($user->fields->Função[0]) && ( $user->fields->Função[0] == "Administração" ||  $user->fields->Função[0] == "Falcão" ))
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Falcão</div>

                <div class="panel-body">

                    <div class="col-lg-4">
                        <b>Abordagens</b>

                        <a href="{{ url('abordagens') }}" class="btn btn-primary btn-custom">Cadastro de abordagens</a>
                        <a href="{{ url('os') }}" class="btn btn-primary btn-custom">Subir Ordens de Serviço</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif


    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Programa de Pontos Vittá</div>

                <div class="panel-body">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{url('/produtos')}}" style="width: 100%; margin-bottom: 10px;">Catálogo de Produtos</a>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-primary" style="width: 100%">Seu saldo é de:<br> V$ {{ $user->fields->ScoreAtual or "" }} Vittalecas</button>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-danger" style="width: 100%">Total já trocado:<br> V$ {{ $user->fields->RequisiçõesAprovadasVittalecas or "" }} Vittalecas</button>
                    </div>

                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Produto Trocado</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        @if(isset($user->fields->RequisiçõesDeCompraVittalecas))
                            @foreach($user->fields->RequisiçõesDeCompraVittalecas as $requisicoes)

                            <?php
                            switch ($requisicoes->Status) {
                                case 'Reprovado':
                                    $btn = "btn-danger";
                                    break;
                                
                                case 'Aprovado':
                                    $btn = "btn-primary";
                                    break;

                                case 'Recebido':
                                    $btn = "btn-success";
                                    break;

                                default:
                                    $btn = "btn-warning";
                                    break;
                            }
                            ?>
                                <tr>
                                    <td>{{ $requisicoes->Produto[0]->Produto or '' }}</td>
                                    <td>{{ $requisicoes->ValorRequisição or '' }}</td>
                                    <td><span class="btn {{$btn}}" style="width: 100%"> {{ $requisicoes->Status }}</span></td>
                                </tr>
                            @endforeach
                        @endif
                        <tfoot>
                            <tr>
                                <td>Total:</td>
                                <td>{{ $user->fields->RequisiçõesAprovadasVittalecas or '' }}</td>
                                <td></td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Extrato Vittalecas</div>

                <div class="panel-body">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{url('http://clinicavittagoiania.com.br/vittalecas/vittalecas/regulamento')}}" style="width: 100%; margin-bottom: 10px;">Entenda como conseguir as Vittalecas</a>
                    </div>
                    <div class="col-lg-12 table-responsive">
                        @if( isset($user->fields->Tipo) && $user->fields->Tipo == 'Colaborador' )
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Mês</th>
                                    <th scope="col">Soma</th>
                                    <th scope="col">Meta Geral</th>
                                    <th scope="col">Meta Acumulada</th>
                                    <th scope="col">Faltas no Mês</th>
                                    <th scope="col">Adicionais</th>
                                    <th scope="col">Atrasos</th>
                                    <th scope="col">Participação em Treinamentos</th></th>
                                    <th scope="col">Contrato de Meta</th></th>
                                    <th scope="col">Indicador 1</th></th>
                                    <th scope="col">Indicador 2</th></th>
                                    <th scope="col">Resultado do Setor 1</th></th>
                                    <th scope="col">Resultado do Setor 2</th></th>
                                    <th scope="col">Resultado do Setor 3</th></th>
                                    <th scope="col">Pesquisa de Satisfação</th></th>
                                    @if( isset($user->fields->Função) && $user->fields->Função == 'Supervisor')
                                        <th scope="col">Pesquisa de Satisfação</th></th>
                                        <th scope="col">Ranking no Projeto</th></th>
                                        <th scope="col">Timing no Projeto</th></th>
                                        <th scope="col">Qualidade no Projeto</th></th>
                                        <th scope="col">Escola de Líderes</th></th>
                                        <th scope="col">Notas nos Módulos</th></th>
                                        <th scope="col">Média do Time</th></th>
                                    @endif
                                </tr>
                            </thead>
                            @if(isset($user->fields->Score))
                                @foreach($user->fields->Score as $score)
                                    <tr>
                                        <td>{{ $score->Mês or null }}</td>
                                        <td>{{ $score->Total or null }}</td>
                                        <td>{{ $score->MetaGeral or null }}</td>
                                        <td>{{ $score->MetaAcumulado or null }}</td>
                                        <td>{{ $score->FaltasNoMês or null }}</td>
                                        <td>{{ $score->Adicionais or null }}</td>
                                        <td>{{ $score->Atrasos or null }}</td>
                                        <td>{{ $score->ParticipaçãoEmTreinamento or null }}</td>
                                        <td>{{ $score->ClassificaçãoContratoDeMetas or null }}</td>
                                        <td>{{ $score->Indicador1 or null }}</td>
                                        <td>{{ $score->Indicador2 or null }}</td>
                                        <td>{{ $score->ResultadosDoSetor1 or null }}</td>
                                        <td>{{ $score->ResultadosDoSetor2 or null }}</td>
                                        <td>{{ $score->ResultadosDoSetor3 or null }}</td>
                                        <td>{{ $score->PesquisaDeSatisfação or null }}</td>
                                        @if( isset($user->fields->Função) && $user->fields->Função == 'Supervisor')
                                            <td>{{ $score->RankingNoProjeto or null }}</td>
                                            <td>{{ $score->TimeNoProjeto or null }}</td>
                                            <td>{{ $score->QualidadeNoReporte or null }}</td>
                                            <td>{{ $score->EscolaDeLíderes or null }}</td>
                                            <td>{{ $score->NotasNosMódulos or null }}</td>
                                            <td>{{ $score->MédiaDoTime or null }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endif
                        @endif
                        
                        

                        
                        @if( isset($user->fields->Tipo) && $user->fields->Tipo == 'Médico' )
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Mês</th>
                                    <th scope="col">Soma</th>
                                    <th scope="col">Número De Agendas Abertas</th>
                                    <th scope="col">Bloqueios</th>
                                    <th scope="col">Satisfação</th>
                                    <th scope="col">PCE</th>
                                    <th scope="col">NúmeroDeIndicações</th>
                                </tr>
                            </thead>
                            @if(isset($user->fields->ScoreMédicoLink))
                                @foreach($user->fields->ScoreMédicoLink as $score)
                                    <tr>
                                        <td>{{ $score->Mês or null }}</td>
                                        <td>{{ $score->Total or null }}</td>
                                        <td>{{ $score->NúmeroDeAgendasAbertas or null }}</td>
                                        <td>{{ $score->Bloqueios or null }}</td>
                                        <td>{{ $score->Satisfação or null }}</td>
                                        <td>{{ $score->PCE or null }}</td>
                                        <td>{{ $score->NúmeroDeIndicações or null }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style type="text/css">
    .btn-custom{
        width: 100%;
        margin-top: 5px;
    }
</style>
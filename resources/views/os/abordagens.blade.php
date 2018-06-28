@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Clínica Vitta Goiânia - Abordagens</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-info">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ url('/falcao/abordagens/store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nome do paciente</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Digite o nome">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
                            <label for="cpf" class="col-md-4 control-label">CPF ou RG</label>
                            <div class="col-md-6">
                                <input id="cpf" type="text" class="form-control" name="cpf" value="{{ old('cpf') }}"  autofocus placeholder="Digite o CPF">
                                @if ($errors->has('cpf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cpf') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('medico') ? ' has-error' : '' }}">
                            <label for="medico" class="col-md-4 control-label">Nome do Médico</label>
                            <div class="col-md-6">
                                <input list="medicos" name="medico" id="medico" type="text" class="form-control">

                                <datalist id="medicos">
                                    @foreach($medicos as $medico)
                                        <option value="{{ $medico->fields->Nome }}">
                                    @endforeach
                                </datalist>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('hasExam') ? ' has-error' : '' }}">
                            <label for="hasExam" class="col-md-4 control-label">Estava com algum pedido de exame?</label>
                            <div class="col-md-6">
                                <input type="radio" value="yes" name="pedido_exame" class="check">Sim <br>
                                <input type="radio" value="no" name="pedido_exame" class="check">Não <br>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('origem') ? ' has-error' : '' }}">
                            <label for="origem" class="col-md-4 control-label">Origem</label>
                            <div class="col-md-6">
                <input type="radio" value="1" name="origem" class="check">Consulta<br>
                <input type="radio" value="2" name="origem" class="check">Retorno<br>
                <input type="radio" value="3" name="origem" class="check">Exames<br>
                <input type="radio" value="4" name="origem" class="check">Orçamento Direto<br>
                <input type="radio" value="5" name="origem" class="check">Acompanhante<br>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('valor_orcado') ? ' has-error' : '' }}">
                            <label for="valor_orcado" class="col-md-4 control-label">Qual foi o valor do orçamento?</label>
                            <div class="col-md-6">
                                <input id="valor_orcado" type="number" class="form-control" name="valor_orcado">
                                @if ($errors->has('valor_orcado'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('valor_orcado') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('venda') ? ' has-error' : '' }}">
                            <label for="venda" class="col-md-4 control-label">Houve Venda?</label>
                            <div class="col-md-6">
                                <input id="venda" type="checkbox" class="check" value="true" name="venda">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Confirmar
                                </button>
                            </div>
                        </div>
                    </form>
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
    .check{
        height: 20px;
        width: 20px;
    }
</style>
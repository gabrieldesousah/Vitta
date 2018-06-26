@extends('layouts.pacientes')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Clínica Vitta Goiânia - Cadastro de paciente</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-info">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ url('/pacientes/store') }}">
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

                        <div class="form-group{{ $errors->has('born') ? ' has-error' : '' }}">
                            <label for="born" class="col-md-4 control-label">Data de nascimento</label>
                            <div class="col-md-6">
                                <input id="born" type="date" class="form-control" name="born" value="{{ old('born') }}"  autofocus placeholder="Data">
                                @if ($errors->has('born'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('born') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('rg') ? ' has-error' : '' }}">
                            <label for="rg" class="col-md-4 control-label">RG</label>
                            <div class="col-md-6">
                                <input id="rg" type="text" class="form-control" name="rg" value="{{ old('rg') }}"  autofocus placeholder="Digite o RG">
                                @if ($errors->has('rg'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('rg') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
                            <label for="cpf" class="col-md-4 control-label">CPF</label>
                            <div class="col-md-6">
                                <input id="cpf" type="text" class="form-control" name="cpf" value="{{ old('cpf') }}"  autofocus placeholder="Digite o CPF">
                                @if ($errors->has('cpf'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cpf') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('date_exam') ? ' has-error' : '' }}">
                            <label for="date_exam" class="col-md-4 control-label">Dia do exame</label>
                            <div class="col-md-6">
                                <input id="date_exam" type="date" class="form-control" name="date_exam" value="{{ old('date_exam') }}"  autofocus placeholder="">
                                @if ($errors->has('date_exam'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('date_exam') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Telefone</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}"  autofocus placeholder="">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Senha</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password"  placeholder="Digite sua senha">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
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
</style>
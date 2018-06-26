@extends('layouts.pacientes')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Clínica Vitta Goiânia</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-info">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <div class="col-lg-4">
                        <form class="form-horizontal" method="POST" action="{{ url('buscarresultados/hermespardini/getpatients') }}">
                            {{ csrf_field() }}

                            <h2>Hermes Pardini</h2>

                            <div class="form-group{{ $errors->has('login') ? ' has-error' : '' }}">
                                <label for="login" class="col-md-4 control-label">Usuário</label>

                                <div class="col-md-8">
                                    <input id="login" type="text" class="form-control" name="login" value="{{ old('login') }}" required autofocus placeholder="Digite seu login">

                                    @if ($errors->has('login'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('login') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Senha</label>

                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control" name="password" value="{{ old('password') }}" required autofocus placeholder="Digite a senha">

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

</div>
@endsection

<style type="text/css">
    .btn-custom{
        width: 100%;
        margin-top: 5px;
    }
</style>
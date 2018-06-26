@extends('layouts.pacientes')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Clínica Vitta Goiânia - Resultados de Exames</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-info">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ url('/resultados/auth') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('document') ? ' has-error' : '' }}">
                            <label for="document" class="col-md-4 control-label">RG</label>

                            <div class="col-md-6">
                                <input id="document" type="text" class="form-control" name="document" value="{{ old('document') }}" required autofocus placeholder="Digite seu documento">

                                @if ($errors->has('document'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('document') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Senha</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required placeholder="Digite sua senha">

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

                                <a href="#" data-toggle="tooltip" data-placement="top" title="Experimente seu CPF ou RG, Caso não consiga, ligue para nós">Esqueceu sua senha?</a>
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
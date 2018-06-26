<?php echo isset($erro)?"<h1>Erro: ".$erro."</h1>":""; ?>    

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                                    
                <div class="panel-heading">Subir planilha</div>

                <div class="panel-body">

                    @if (session('status'))
                    <div class="alert alert-info">
                        {{ session('status') }}
                        </div>
                    @endif

                    <form method="post" enctype="multipart/form-data" action="{{ url('/os')}}">
                      {{ csrf_field() }}
                        <div class="form-group col-lg-12">

                            <div class="row">
                                <label>Arquivo:</label>
                                <input class="form-control" type="file" name="file" />
                            </div>
                            <br>
                            <div class="row">
                                <input type="submit" value="Enviar" class="btn btn-succes" />
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

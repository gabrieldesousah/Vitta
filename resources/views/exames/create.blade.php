@extends('layouts.app')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Adicionar Exame
                </h1>
            </div>
        </div>
        <!-- /.row -->
        
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <a href="{{ url('/orcamento') }}" class="btn btn-info">Voltar no Orçamento</a>
                <br><br>

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ url('/exames') }}" method="POST">
                    <?php
                     date_default_timezone_set('America/Sao_Paulo'); 
                     $time = date('H:i');
                    ?>
                        {{ csrf_field() }}

                    <div class="form-group">
                        <label for="local">Local</label>
                        <input name="local" id="local" class="form-control" autofocus placeholder="Ex: CIMRAD">
                    </div>

                    <div class="form-group">
                        <label for="categoria">Categoria</label>
                        <input name="categoria" id="categoria" class="form-control" placeholder="Ex: Raio-X">
                    </div>

                    <div class="form-group">
                        <label for="nome">Nome do Exame:</label>
                        <input name="nome" class="form-control" id="nome">
                    </div>

                    <div class="form-group">
                        <label for="preco_final">Preço Final</label>
                        <input name="preco_final" class="form-control" id="preco_final">
                    </div>

                    <div class="form-group">
                        <label for="preco_vitta">Preço Vittá</label>
                        <input type="text" name="preco_vitta" id="preco_vitta" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="preco_parceiro">Preço no parceiro</label>
                        <input type="text" name="preco_parceiro" id="preco_parceiro
                        " class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="obs">Observações</label>
                        <input type="text" name="obs" id="obs" class="form-control">
                    </div>
                
                    <input type="hidden" name="hora_atendimento" value="<?php echo $time;?>">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    
                    <div class="form-group">
                        <input type="submit" value="Confirmar" class="btn btn-success btn-lg">
                    </div>
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
</div>

@endsection
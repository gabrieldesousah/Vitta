@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Pacientes</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ url('listapacientes') }}">Voltar para a lista dos pacientes</a>
                    <br><br>
                    
                    <div>
                      <span><b>Nome:</b> {{ $paciente->name }}</span><br>
                      <span><b>Unidade:</b> {{ $paciente->unidade }}</span><br>
                      <span><b>Email:</b> {{ $paciente->email }}</span><br>
                      <span><b>Documento:</b> {{ $paciente->rg or $paciente->cpf }}</span><br>
                      <span><b>Data de nascimento:</b> {{ $paciente->born }}</span><br>
                      <span><b>Data do último exame:</b> {{ $paciente->date_exam }}</span><br>

                      <h2>Resultados</h2>
                      <table class="table">
                        <thead>
                            <th>Laboratório</th>
                            <th>Pedido</th>
                            <th>Ano do pedido</th>
                            <th>Link para Download</th>
                        </thead>
                        @foreach( $exames as $exam )
                        <tr>
                            <td>{{ $exam->laboratory }}</td>
                            <td>{{ $exam->ped }}</td>
                            <td>{{ $exam->anoped }}</td>
                            <td>
                                <a href="{{ url('/') }}/<?php echo utf8_decode(urldecode($exam->path_file)); ?>" target="_blank">Download</a>
                            </td>
                        </tr>
                        @endforeach
                      </table>
											
											<h2>Cadastrar novo resultado</h2>

                      <form action="{{ url('/pacientes', [$paciente->id, 'edit']) }}" class="form-inline" method="post" enctype="multipart/form-data">
                      	<div class="form-group">
                      		Laboratório:
	                      	<select class="form-control" id="laboratorio" name="laboratorio">
	                      		<option value="padrao">Padrão</option>
	                      		<option value="general">General</option>
	                      		<option value="psy">Psy</option>
	                      		<option value="hp">Hermes Pardini</option>
	                      		<option value="outro">Outros</option>
	                      	</select>
                      </div>
                      <div class="form-group">
                      	Upload do resultado:
                      	<input type="file" id="file" name="file" class="form-control">
                      </div>
                      <div class="form-group">
                      	<button class="btn btn-success">Enviar</button>
                      </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
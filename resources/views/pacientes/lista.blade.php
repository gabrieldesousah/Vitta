@extends('layouts.app')

@section('content')
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script> 
<script type="text/javascript">
$(function(){
    $("#tabela input").keyup(function(){       
        var index = $(this).parent().index();
        var nth = "#tabela td:nth-child("+(index+1).toString()+")";
        var valor = $(this).val().toUpperCase();
        $("#tabela tbody tr").show();
        $(nth).each(function(){
            if($(this).text().toUpperCase().indexOf(valor) < 0){
                $(this).parent().hide();
            }
        });
    });
 
    $("#tabela input").blur(function(){
        $(this).val("");
    });
});
</script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Pacientes</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <table class="table table-striped" id="tabela">
                        <thead>
                        	<tr>
                            <th>Nome</th>
                            <th>Unidade</th>
                            <th>Email</th>
                            <th>Documento</th>
                            <th>Data de Nascimento</th>
                            <th>Data do Exame</th>
                            <th>Data de atualização</th>
                            <th></th>
                          </tr>
                          <tr>
                            <th><input type="text" id="name"/></th>
                            <th><input type="text" id="unidade"/></th>
                            <th></th>
                            <th><input type="text" id="documento"/></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                          </tr>   
                        </thead>
                        <tbody>
                        @foreach( $pacientes as $paciente )
                        <tr>
                            <td class="nome">{{ $paciente->name }}</td>
                            <td class="unidade">{{ $paciente->unidade }}</td>
                            <td class="email">{{ $paciente->email }}</td>
                            <td class="documento">{{ $paciente->rg or $paciente->cpf }}</td>
                            <td class="born">{{ $paciente->born }}</td>
                            <td class="date_exam">{{ $paciente->date_exam }}</td>
                            <td class="updated_at">{{ $paciente->updated_at }}</td>
                            <td><a href="{{ url('/pacientes', [$paciente->id]) }}">Editar</a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
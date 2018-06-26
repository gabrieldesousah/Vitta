@extends('layouts.pacientes')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Seus resultados</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
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
                                <a href="{{ url('/resultados/file') }}/{{ $exam->id }}?token={{$_GET['token']}}" target="_blank">Download</a>
                            </td>
                        </td>
                        @endforeach
                    </table>
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
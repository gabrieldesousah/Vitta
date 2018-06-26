@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $user->fields->Nome }}</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href="{{ url('/colaboradores') }}">Voltar a lista de colaboradores</a>
                	<br><br>
                    
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

                        @if(isset($user->fields->Contratações[0]->Função))
                            <b>Função:</b> {{ $user->fields->Contratações[0]->Função }}
                            <br>
                        @endif

                        @if(isset($user->fields->Contratações[0]->Função))
                            <b>Setor:</b> {{ $user->fields->Contratações[0]->Setor }}
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

                        <br> 

                        @if(isset($user->fields->TempoDeCasa))
                            <b>{{ number_format($user->fields->TempoDeCasa, 0) }} meses na Vittá</b>
                            <br>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-offset-2" style="text-align: right">
            <a class="btn btn-primary" href="{{url('/produtos')}}">Voltar ao catálogo</a>
            <br><br>
        </div>
        
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                	{{$produto->fields->Produto}}
                </div>

                <div class="panel-body">

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <div class="col-md-6">
                        <img style="width: 100%" src="{{$produto->fields->Foto[0]->url}}">
                    </div>

                    <div class="col-lg-2"></div>
                    
                    <div class="col-lg-4">
                        <br><br>
					    <button class="btn btn-warning" style="width: 100%">Custo: {{$produto->fields->Vittalecas}} Vittalecas</button>
                        <br><br>
                        <button class="btn btn-primary" style="width: 100%">Você possui {{$user->fields->ScoreAtual}} Vittalecas</button>
                        <br><br>
                        <?php date_default_timezone_set('UTC'); ?>
                   
                        @if( $user->fields->ScoreAtual >= $produto->fields->Vittalecas)
                        <?php $sobra = $user->fields->ScoreAtual - $produto->fields->Vittalecas; ?>
                            
                             @if( date("d") > 5 and date("d") <= 10 ) 
                                <a href="{{ url('/trocar') }}/{{ $produto->id }}" class="btn btn-success" style="width: 100%" onclick="return confirm('Tem certeza que fará essa troca? Você terá {{ $sobra }} Vittalecas após isso.')">Trocar</a>
                            @else
                                <button class="btn" style="width: 100%; word-break: break-all; white-space: unset">Fora do período de trocas <br>
                                ( Aguardar apuração )</button>
                            @endif
                        @else
                            <button class="btn" style="width: 100%; word-break: break-all; white-space: unset">Você ainda não tem <br>Vittalecas suficientes <br>para este produto</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

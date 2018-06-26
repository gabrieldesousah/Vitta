@extends('layouts.app')

@section('content')
<div class="container">
        <div class="col-lg-12">
            <h2>Catálogo</h2><br>
        </div>
        @foreach ($request as $r)
            @foreach($r['records'] as $produto)
            <div class="col-md-4" style="height: 350px; margin-bottom: 20px;">
                <div class="panel panel-default">
                    <div class="panel-heading" style="height: 60px; overflow: hidden;"><span><b>{{$produto->fields->Produto}}</b></span></div>

                    <a href="{{ url('produto/') }}/{{ $produto->id }}">
                        <div class="panel-body" style="height: 250px; width: 100%; overflow: hidden; padding: 0; margin: 0;">
                            <img src="{{$produto->fields->Foto[0]->url}}" style="width: 100%; height: 100%;">
                        </div>
                    </a>
                    <div class="panel-footer" style="font-weight: 800; color: #1a316c; text-align: center;">V$ {{$produto->fields->Vittalecas}} Vittalecas</div>
                </div>
            </div>
            @endforeach
        @endforeach

    </div>
</div>
@endsection

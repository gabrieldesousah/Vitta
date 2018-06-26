@extends('layouts.app')

@section('content')

    @if( isset($today) && $today != false )
        <meta http-equiv="refresh" content="10;url={{ Request::url() }}" />
    @endif

    <div id="app" class="col-lg-12">

        <div class="container" id="form-page">
            <div class="panel panel-default" id="panel-form">
                <div class="panel-body">
                  <div class="col-lg-4">
                    <b>Triagem</b>
                    <br>
                    <a href="{{ url('triagem/hoje/1') }}" class="btn btn-info">Independência</a>
                    <a href="{{ url('triagem/hoje/2') }}" class="btn btn-info">Buriti</a>
                  </div>
                </div>
            </div>  
        </div>
      </div>
    </div>
  </div>

@endsection
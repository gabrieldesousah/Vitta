@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            	<div class="panel-heading">{{ $detalhes }}</div>
                <div class="panel-body">
			    	<table class="table">
			    		<thead>
			    			<th>Nome</th>
			    		</thead>
			    		@foreach( $users as $user )
			    		<tr>
			    			<td><a href="{{ url('/colaborador', [$user->id]) }}">{{ $user->fields->Nome }}</a></td>
			    		</tr>
			    		@endforeach
			    	</table>
		    	</div>
		    </div>
		</div>
    </div>
</div>
@endsection

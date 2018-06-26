@extends('layouts.app')

@section('content')

<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Orçamentos
                </h1>
            </div>
        </div>
        <!-- /.row -->
        
        <div class="row">

          <div class="col-lg-4">

            @if(old('exames'))
              <div class="col-lg-12 alert alert-success">  
                <h2 style="text-transform: capitalize">*Orçamento {{old('nome')}}*</h2><br>
                
                <?php $total = 0; ?>
                @foreach(old('exames') as $exame)            
                    <?php $ex = $exames->find($exame); ?>                
                        *{{$ex->nome}} <br>
                        R$ {{$ex->preco_final}}*.

                        @if($ex->obs != "")
                            <br>{{$ex->obs}}
                        @endif
                        <?php $vc = intval($ex->preco_parceiro);
                        $vf = intval($ex->preco_final);                
                        $r = $vf-$vc;
                        ?>
                        @if($vc != 0)
                            <br>
                            Sendo {{ $r }} pagos na Clínica Vittá e {{ $vc }} pagos na clínica parceira( {{$ex->local}} ).
                        @endif
                        <br><br>
                        <?php $total += $vf; ?>
                @endforeach
                <p>*Valor Total: R$ {{ $total }}*</p>
                <br>--------------------------------<br>
                Obs.: <br>
                1)Consultas são pagas somente em dinheiro e precisam ser agendadas<br>
                2)Todas as consultas tem direito a retorno em 15 dias, com exceção de psiquiatria e psicologia.
                <br>--------------------------------<br>
                <p style="text-transform: capitalize">{{ Auth::user()->name }}</p>
                <p>Clínica Vittá Goiânia</p>
              </div>
            @endif
          </div>

            <div class="col-lg-8">      
                <form action="{{ url('/orcamento') }}" method="POST" class="form-inline">
                  <?php
                    date_default_timezone_set('America/Sao_Paulo'); 
                    $time = date('H:i');
                  ?>

                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-lg-12" style="padding: 15px; position: fixed; top: 90px; background: #FFF; width: 100%">
                            <div class="form-group">
                                <label for="nome">Paciente:</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do Paciente">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Gerar Orçamento" class="col-md-4 form-control btn btn-info">
                            </div>
                        </div>
                    </div>
                
                <a class="btn btn-default" href="{{ url('/exames') }}">Adicionar novo exame</a>
                <br><br>
                <table  class="table table-bordered">
                    <thead>
                        <th><b>Exame</b></th>
                        <th><b>Categoria</b></th>
                        <th><b>Valor Final</b></th>
                    </thead>
                
                    @foreach($exames as $exame)
                      <tr>
                          <td>
                             <input type="checkbox" id="exame{{$exame->id}}" name="exames[]" value="{{$exame->id}}">
                            <label for="exame{{$exame->id}}">{{$exame->nome}}</label>
                            <a href="exame/{{$exame->id}}">Editar</label>
                          </td>
                          <td>{{$exame->categoria}}</td>
                          <td>{{$exame->preco_final}}</td>
                      </tr>
                    @endforeach
                </table>
                <br><br>
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                </form>
                <br><br><br><br><br><br><br><br>
            </div>
            <!-- /DIV.COL-LG-8 -->
        </div>
    </div>
</div>
@endsection
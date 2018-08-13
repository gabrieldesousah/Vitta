@extends('layouts.app')

@section('content')

    @if( isset($now) && $now == true )
        <meta http-equiv="refresh" content="17;" />
    @endif
    <div id="app" class="col-lg-12">

        <div class="container" id="form-page">
            <div class="panel panel-default" id="panel-form">
                <div class="panel-body">
                    <h2>Triagem</h2>
                  
                    <div class="row">
                    <div class="col-lg-4">
                        <h3>Filtros</h3>
                        <form class="form-horizontal" method="GET" action="{{ url('/triagem/filtro') }}">
                            Data de início: <br>
                            <input type="date" name="date_start" value='{{ $_GET["date_start"] or date("Y-m-d",strtotime("-30 days")) }}' placeholder='{{ $_GET["date_start"] or date("Y-m-d",strtotime("-30 days")) }}'>
                            <!--input type="time" name="hour_start" value="{{ $_GET['hour_start'] or '00:00' }}" placeholder="{{ $_GET['hour_start'] or '00:00' }}"><br-->
                            <br>

                            Data final: <br>
                            <input type="date" name="date_end" value="{{ $_GET['date_end'] or date('Y-m-d') }}" placeholder="{{ $_GET['date_end'] or date('Y-m-d') }}">
                            <!--input type="time" name="hour_end" value="{{ $_GET['hour_end'] or '23:59' }}" placeholder="{{ $_GET['hour_end'] or '23:59' }}"><br-->
                           <br>
                            Unidade:<br>
                            <select name="unidade"><br>
                                <?php $unidade = $unidade ?? 1; ?>
                                <option value="1"
                                {{ ($unidade == 1) ? 'selected' : '' }}>Independencia</option>
                                <option value="2" {{ ($unidade == 2) ? 'selected' : '' }}>Buriti</option>
                            </select>
                            <br>

                            Serviço:<br>
                            <select name="servico"><br>
                                <option value="todos"{{ ($servico == false) ? 'selected' : '' }}>
                                  Todos
                                </option>
                                <option value="caixa"{{ ($servico == 'caixa') ? 'selected' : '' }}>
                                  Caixa
                                </option>
                                <option value="recepcao"{{ ($servico == 'recepcao') ? 'selected' : '' }}>
                                  Recepção
                                </option>
                            </select>

                            <br><br>
                            {{ csrf_field() }}
                                                        
                            <button type="submit" class="btn btn-danger" name="now" value="true">
                                Últimos 15 minutos
                            </button>

                            <button type="submit" class="btn btn-primary" name="today" value="true">
                                Dados de hoje
                            </button>
                            <br><br>

                            <button type="submit" class="btn btn-warning">
                                Gerar para o período
                            </button>
                        </form>
                    </div>

                    <div class="col-lg-4">
                      @if(isset($tmacollect))
                        <h3>Dados</h3>
                          Quartil 1: {{ date("H:i:s",$slice1->avg()) }} <br>
                          Quartil 2: {{ date("H:i:s",$slice2->avg()) }} <br>
                          Quartil 3: {{ date("H:i:s",$slice3->avg()) }} <br>
                          Quartil 4: {{ date("H:i:s",$slice4->avg()) }} <br>
                          <strong>
                              Média Geral: 
                              {{ date("H:i:s",$tmacollect->avg()) }}
                          </strong>

                          <br><br>

                          <strong>
                              Piores tempos do período: <br> 
                          </strong>
                            @foreach( $piores_tempos as $pior_tempo )
                                {{ date("H:i:s",$pior_tempo) }} <br>
                            @endforeach
                      @endif
                    </div>

                    <div class="col-lg-4">
                      @if(isset($tmacollect))
                        <h3>Status</h3>
                          <strong>
                               
                          <?php 
                          // dd($servico);
                          if( $servico == "recepcao" ){
                            $param_amarelo = "00:10:00";
                            $param_verm = "00:15:00";
                          }else{
                            $param_amarelo = "00:7:00";
                            $param_verm = "00:10:00";                            
                          }

                          ( date("H:i:s",$piores_tempos->last()) < $param_amarelo ) 
                          ? $color_="verde" 
                          : (
                              ( date("H:i:s",$piores_tempos->last()) < $param_verm ) 
                                ? $color_="amarelo"
                                : $color="vermelho"
                            );

                          $cor_pior_tempo = ( date("H:i:s",$piores_tempos->last()) < $param_amarelo ) 
                          ? $color_="verde" 
                          : (
                              ( date("H:i:s",$piores_tempos->last()) < $param_verm ) 
                                ? $color_="amarelo"
                                : $color="vermelho"
                            );
                          
                          $cor_pior_quartil = ( date("H:i:s",$slice4->avg()) < $param_amarelo ) 
                          ? $color_="verde" 
                          : (
                              ( date("H:i:s",$slice4->avg()) < $param_verm ) 
                                ? $color_="amarelo"
                                : $color="vermelho"
                            );
                          
                          $cor_media = ( date("H:i:s",$tmacollect->avg()) < $param_amarelo ) 
                          ? $color_="verde" 
                          : (
                              ( date("H:i:s",$tmacollect->avg()) < $param_verm ) 
                                ? $color_="amarelo"
                                : $color="vermelho"
                            );

                          ?>
                          <div class="row">
                            <div class="col-lg-4">
                              <h3>Piores tempos</h3>
                              <img src="{{ url('public/img/icons', [$cor_pior_tempo]) }}.png" alt="{{ $cor_pior_tempo }}" title="{{ $cor_pior_tempo }}" width="60" height="120" align="left">
                            </div>
                            <div class="col-lg-4">
                              <h3>Pior quartil</h3>
                              <img src="{{ url('public/img/icons', [$cor_pior_quartil]) }}.png" alt="{{ $cor_pior_quartil }}" title="{{ $cor_pior_quartil }}" width="60" height="120" align="left">
                            </div>
                            <div class="col-lg-4">
                              <h3>Média geral</h3>
                              <img src="{{ url('public/img/icons', [$cor_media]) }}.png" alt="{{ $cor_media }}" title="{{ $cor_media }}" width="60" height="120" align="left">
                            </div>
                            <div class="col-lg-12">
                              @switch($cor_media)
                                  @case("verde")
                                      O tempo de espera está dentro do planejado, pode continuar ofertando nossos serviços da forma mais completa possível
                                      @break
                                  @case("amarelo")
                                      Nosso tempo de espera está se elevando... Vamos tomar cuidado para não prejudicar a percepção do paciente
                                      @break
                                  @case("vermelho")
                                      Cuidado! Nossos pacientes estão esperando demais, acelere o processo e diminua as informações passadas para eles
                                      @break
                              @endswitch
                            </div>
                          </div>
                      @endif
                    </div>
                </div>
                            <br>

            <div style="padding: 0">
              @if(isset($tmacollect))
                <script type="text/javascript">
                  google.charts.load('current', {'packages':['corechart','bar']});
                  google.charts.setOnLoadCallback(drawChart);
                  google.charts.setOnLoadCallback(drawChart2);
                  function drawChart() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Horário');
                    data.addColumn('timeofday', 'Tempo de espera');
                    data.addRows([
                      ['7hr', [<?php echo date('H, i, s', $faixa07); ?>]],
                      ['8hr', [<?php echo date('H, i, s', $faixa08); ?>]],
                      ['9hr', [<?php echo date('H, i, s', $faixa09); ?>]],
                      ['10hr', [<?php echo date('H, i, s', $faixa10); ?>]],
                      ['11hr', [<?php echo date('H, i, s', $faixa11); ?>]],
                      ['12hr', [<?php echo date('H, i, s', $faixa12); ?>]],
                      ['13hr', [<?php echo date('H, i, s', $faixa13); ?>]],
                      ['14hr', [<?php echo date('H, i, s', $faixa14); ?>]],
                      ['15hr', [<?php echo date('H, i, s', $faixa15); ?>]],
                      ['16hr', [<?php echo date('H, i, s', $faixa16); ?>]],
                      ['17hr', [<?php echo date('H, i, s', $faixa17); ?>]],
                      ['18hr', [<?php echo date('H, i, s', $faixa18); ?>]],
                      ['19hr', [<?php echo date('H, i, s', $faixa19); ?>]]
                    ]);

                    var options = {
                        legend:{
                            position: 'none'
                        },
                      title: 'Tempo de espera médio para chamada por faixa de horário',
                      height: 400
                    };
                    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_tma'));
                    chart.draw(data, google.charts.Bar.convertOptions(options));
                  }

                  function drawChart2() {
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Horário');
                    data.addColumn('number', 'Número de Pessoas');
                    data.addRows([
                      ['7hr', <?php echo $qtd_porfaixa07; ?>],
                      ['8hr', <?php echo $qtd_porfaixa08; ?>],
                      ['9hr', <?php echo $qtd_porfaixa09; ?>],
                      ['10hr', <?php echo $qtd_porfaixa10; ?>],
                      ['11hr', <?php echo $qtd_porfaixa11; ?>],
                      ['12hr', <?php echo $qtd_porfaixa12; ?>],
                      ['13hr', <?php echo $qtd_porfaixa13; ?>],
                      ['14hr', <?php echo $qtd_porfaixa14; ?>],
                      ['15hr', <?php echo $qtd_porfaixa15; ?>],
                      ['16hr', <?php echo $qtd_porfaixa16; ?>],
                      ['17hr', <?php echo $qtd_porfaixa17; ?>],
                      ['18hr', <?php echo $qtd_porfaixa18; ?>],
                      ['19hr', <?php echo $qtd_porfaixa19; ?>]
                    ]);
                    var options = {
                        legend:{
                            position: 'none'
                        },
                      title: 'Número de pacientes por faixa de horário',
                      height: 400
                    };
                    var chart = new google.visualization.ColumnChart(document.getElementById('chart_div_pcts'));
                    chart.draw(data, google.charts.Bar.convertOptions(options));
                  }
                </script>
                <div class="row">
                  <div class="col-lg-5">
                    <div id="chart_div_tma"></div>
                  </div>
                  <div class="col-lg-1"></div>
                  <div class="col-lg-5">
                    <div id="chart_div_pcts"></div>
                  </div>
                </div>
              @endif
            </div>  
        </div>
      </div>
    </div>
  </div>

  
@endsection


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style>
    input, select{
        border: none;
        padding: 5px;
    }
    input[type=time]{
        width: 100px;
    }
    select{
        width: 200px;
        height: 35px;
    }
    header{
        width: 100%;
        text-align: center;
        height: 100px;
        padding: 15px;
    }
</style>
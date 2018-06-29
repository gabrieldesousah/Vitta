@extends('layouts.app')

@section('content')
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script> 
<script type="text/javascript">
$(function(){
    $("#tabela input").keyup(function(){
        var pedido_exame = 0;
        var valor_orcado = 0;
        var venda = 0;
        var abordagens = 0;
               
        var index = $(this).parent().index();
        var nth = "#tabela td:nth-child("+(index+1).toString()+")";
        var valor = $(this).val().toUpperCase();
// console.log(valor);
        $("#tabela tbody tr").show();
        $(nth).each(function(t){
            // console.log(t);
            // console.log(valor);
            // console.log($(this).text());
            // console.log($(this).text().toUpperCase().indexOf(valor));
            if($(this).text().toUpperCase().indexOf(valor) < 0){
                $(this).parent().hide();
            }else{
                pedido_exame_field = $("#tabela tbody tr:nth-child("+(t+1).toString()+") .pedido_exame");
                valor_orcado_field = $("#tabela tbody tr:nth-child("+(t+1).toString()+") .valor_orcado");
                venda_field = $("#tabela tbody tr:nth-child("+(t+1).toString()+") .venda");
                
                pedido_a = (pedido_exame_field.text());
                if(pedido_a == "Sim"){
                    pedido_exame++;
                }
                valor_a = parseInt((valor_orcado_field.text()).replace(/[^0-9]/g,''));
                valor_orcado = valor_orcado + valor_a;

                venda_a = (venda_field.text());
                if(venda_a == "Sim"){
                    venda++;
                }

                abordagens = abordagens + 1;

                console.log("pedido_a: "+pedido_a);

                // console.log($(this).text());
            }
        });


        $("#abordagens_total").html(abordagens + " abordagens");
        $("#pedido_exame_total").html(pedido_exame + " pedidos de exame");
        $("#valor_orcado_total").html("R$ " + valor_orcado + " orçado");
        $("#vendas_total").html(venda + " vendas");
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
                <div class="panel-heading">Clínica Vitta Goiânia - Abordagens</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-info">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                  <div class="table-responsive">
                    <table class="table" id="tabela">
                        <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>Unidade</th>
                                <th>Origem</th>
                                <th>Médico</th>
                                <th>Tinha pedido de exame?</th>
                                <th>Valor Orçado</th>
                                <th>Houve venda?</th>
                                <th>Data</th>
                            </tr>
                            <tr>
                                <th><input type="text" id="user"/></th>
                                <th><input type="text" id="unidade"/></th>
                                <th><input type="text" id="origem"/></th>
                                <th><input type="text" id="medico_name"/></th>
                                <th><input type="text" id="pedido_exame"/></th>
                                <th><input type="text" id="valor_orcado"/></th>
                                <th><input type="text" id="venda"/></th>
                                <th><input type="text" id="date"/></th>
                            </tr>   
                        </thead>

                        <?php 
                        $origens = collect([
                            '0' => '0',
                            '1' => 'Consulta',
                            '2' => 'Retorno',
                            '3' => 'Exames',
                            '4' => 'Orçamentos Diretos',
                            '5' => 'Acompanhante'
                        ]);
                        ?>
                        <tbody>
                        @foreach($abordagens as $abordagem)
                            <tr>
                                <td class="name">{{$abordagem->user->name}}</td>
                                <td class="unidade">{{$abordagem->unidade}}</td>
                                <td class="origem">{{$origens->values()->get($abordagem->origem)}}</td>
                                <td class="medico_name">{{$abordagem->medico_name}}</td>
                                <td class="pedido_exame">{{($abordagem->pedido_exame == 'yes' ? 'Sim' : 'Não')}}</td>
                                <td class="valor_orcado">R$ {{$abordagem->valor_orcado}}</td>
                                <td class="venda">{{($abordagem->venda == 'true') ? 'Sim' : 'Não'}}</td>
                                <td class="date">{{ date('d/m', strtotime($abordagem->created_at)) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                  
                    <table class="table">
                        <thead>
                            <tr>
                                <td id="abordagens_total">{{ count($abordagens) }} Abordagens</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id="pedido_exame_total">{{ count($abordagens->where('pedido_exame', 'yes')) }} Pedidos de exame</td>
                                <td id="valor_orcado_total">R$ {{ $abordagens->sum('valor_orcado') }} valores orçados no total</td>
                                <td id="vendas_total">{{ count($abordagens->where('venda', 'true')) }} Vendas</td>
                                <td></td>
                            </tr>
                        </thead>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

<style type="text/css">
input {
    width: 100%;
}
</style>

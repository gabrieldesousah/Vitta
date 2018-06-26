@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                                    
                <div class="panel-heading">Erros</div>

                <div class="panel-body">
                    
                    <div class="col-lg-12">
                        <?php
                        $options='<option value="ignorar">Ignorar</option>';
                        foreach($colunasAceitas as $tipo=>$coluna){
                            $options.='<option value="'.$tipo.'">'.$coluna[0].'</option>';
                        }
                        $qtde = sizeof($colunasNaoConhecidas);
                        echo '<h4>'.($qtde>1?$qtde.' colunas importadas n&atilde;o foram reconhecidas':'A seguinte coluna n&atilde;o foi reconhecida').' pelo nosso sistema</h4>
                        <form method="post">';
                        foreach($colunasNaoConhecidas as $i=>$coluna){
                            $val = preg_replace("%[^0-9a-zA-Z]%iUs","",strtolower($coluna));
                            echo '<div class="row">
                            <label>Coluna \'<strong>'.$coluna.'</strong>\':<input name="val['.$i.']" type="hidden" value="'.$val.'" /></label>
                            <select name="tipo['.$i.']">
                                '.$options.'
                            </select>
                        </div>';
                        }
                        ?>
                        {{ csrf_field() }}
                        <?php
                        echo '
                        <input type="submit" value="Enviar" />
                        </form>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

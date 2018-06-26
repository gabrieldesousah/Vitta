<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Vittalecas - Reegulamento</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                margin: 0;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }
            .content{
            	margin-top: 70px;
            	width: 80%;
            	text-align: center;
            }
            .content-text {
                text-align: justify;
                
                margin: 0  auto;
            }

            .title {
                font-size: 45px;
                padding: 0;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Entrar</a>
                        <a href="{{ route('register') }}">Cadastrar</a>
                    @endauth
                </div>
            @endif

            <div class="content">
            	<div class="title">
                    Regulamento
                </div>
	            <div class="content-text">
					<p><b>
					1 - PODEM SER TROCADOS OS PRÊMIOS DE
FORMA AGREGADA. EXEMPLO: O
COLABORADOR TEM 150 VITTALECAS E
GOSTARIA DE PEGAR UM PRÊMIO DE 100
E MAIS UM DE 50. ISSO É POSSÍVEL!

					</b></p>
					<p><b>
					2 - PREMIAÇÕES SUPERIORES A 500
VITTALECAS, EM CASO DE DESEJO DE
TROCA, A EMPRESA POSSUI ATÉ 30 DIAS
CORRIDOS PARA EFETUAR A TROCA
DESEJADA. EM CASO DE FALTA DE
ALGUM PRODUTO, A NÍVEL MERCADO, O
COLABORADOR TERÁ DE ALTERAR SEU
PRÊMIO OU DEIXAR ACUMULADO ATÉ UM
MOMENTO MAIS OPORTUNO.
					</b></p>
					<p><b>
					3 - PREMIAÇÕES SUPERIORES A 1000
VITTALECAS SERÃO TROCADAS EM
VIRADAS DE TRIMESTRES (ABRIL /
JULHO / OUTUBRO / JANEIRO).
					</b></p>
					<p><b>
					4 - EM CASO DE SUSPENSÃO, O COLABORADOR PERDERÁ IMEDIATAMENTE METADE DAS VITTALECAS
ACUMULADAS.
					</b></p>
					<p><b>
					5 - EM CASO DE ADVERTÊNCIA ESCRITA, O COLABORADOR PERDERÁ IMEDIATAMENTE 100 VITTALECAS.
					</b></p>
					<p><b>
					6 - O COLABORADOR QUE PEDIR BAIXA, PODERÁ TROCAR APENAS 80% DAS VITTALECAS, EM PREMIAÇÃO.
					</b></p>
					<p><b>
					7 - O MÉDICO QUE DER BAIXA EM DEFINITIVO NAS SUAS AGENDAS NÃO TERÁ DIREITO A RECOLHER NENHUMA PREMIAÇÃO, AINDA QUE ACUMULADA.
					</b></p>
					<p><b>
					8 - O COLABORADOR COM DEMISSÃO POR JUSTA CAUSA NÃO TERÁ DIREITO A RECOLHER NENHUMA
PREMIAÇÃO, AINDA QUE ACUMULADA.
					</b></p>
					<p><b>
					9 - QUEM PASSAR MAIS DE UM ANO SEM TROCAR NENHUMA DAS VITTALECAS EM PREMIAÇÕES, TERÁ UM
REAJUSTE DE VITTALECAS DE 5% A MAIS (COMO SE FOSSE UMA POUPANÇA).
					</b></p>
					<p><b>
					10 - AS VITTALECAS NÃO SÃO TRANSFERÍVEIS E SOMENTE O PRÓPRIO COLABORADOR PODE AS TROCAR.
					</b></p>
					<p><b>
					11 - AS VITTALECAS, EM SUAS REGRAS GERAIS, SÃO TROCADAS UMA VEZ POR MÊS, NO DIA 10 (EM CASO DE
FERIADO OU FINAL DE SEMANA, ANTECIPA A DATA PARA O DIA ÚTIL ANTERIOR). AS SOLICITAÇÕES DE
TROCAS SÃO FEITAS POR SISTEMA, ATÉ ESTA DATA. EM 10 DIAS UTEIS OS PRÊMIOS
SOLICITADOS, DENTRO DAS REGRAS GERAIS, SERÃO ENTREGUES.
					</b></p>
					<p><b>
					12 - AS VITTALECAS SÓ SERÃO TROCADAS SE VOCÊ TIVER SALDO SUFICIENTE NO PERÍODO DE TROCA
					</b></p>
	            </div>
	            <br><br>
            	<div class="links">
                    <a href="{{ url('/dashboard') }}">Seus dados</a><br><br>
                    <a href="{{ url('/produtos') }}">Cátalogo de Produtos</a><br><br>
                    <a href="{{ url('/vittalecas/oquesao') }}">O que são as Vittalecas?</a><br><br>
                    <a href="{{ url('/vittalecas/regulamento') }}">Regulamento</a>
                </div>
                <br><br>
        </div>
    </body>
</html>

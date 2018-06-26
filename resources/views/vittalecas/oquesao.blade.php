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
            	<div class="title m-b-md">
                    O que são as Vittalecas?
                </div>
	            <div class="content-text">
					<p><b>
					Para aumentar e estreitar nossa relação com
					os parceiros clínicos e os colaboradores, um
					sistema diferenciado e dinâmico foi criado,
					denominado Vittalecas.
					</b></p>
					<p><b>
					As ações de rotina, as interações com os
					pacientes em níveis satisfatórios, bem como as
					buscas por resultados, serão convertidos em
					pontuações, as ditas Vittalecas, que por sua
					vez poderão ser trocadas, conforme regra
					apresentada, em premiações.
					</b></p>
					<p><b>
					Esse catalogo tem, portanto, a função de
					orientar sobre o procedimento de troca e, ao
					mesmo tempo, provocar o interesse de busca
					das Vittalecas acumuladas por uma vasta
					gama de prováveis prêmios.
					</b></p>
					<p><b>
					O catalogo é, ainda na frente de premiações,
					apenas a primeira apresentação de prêmios
					que iremos disponibilizar nessa lógica de
					trocas. Tão logo, através de nosso sistema,
					iremos disponibilizar mais opções e é por onde
					as solicitações de trocas são realizadas.
					Vale lembrar que os prêmios apresentados
					nesse catálogo são meramente ilustrativos, e
					servem para que haja uma noção real e
					palpável sobre o prêmio a ser trocado.
					Aproveitem e vamos as trocas!
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

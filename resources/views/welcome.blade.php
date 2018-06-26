<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        

        <link rel="shortcut icon" href="{{ url('/public/img/logo.png') }}" />
        <link href="{{ url('/public/img/logo.png') }}" />
        <link href="{{ url('/public/img/logo.png') }}" sizes="152x152" />
        <link href="{{ url('/public/img/logo.png') }}" sizes="167x167" />
        <link href="{{ url('/public/img/logo.png') }}" sizes="180x180" />
        <link href="{{ url('/public/img/logo.png') }}" rel="icon" sizes="192x192" />
        <link href="{{ url('/public/img/logo.png') }}" rel="icon" sizes="128x128" />


        <title>Clínica Vittá</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
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

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
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
            <div class="content">
                <div class="title m-b-md">
                    <img width=300 src="{{ url('/public/img/logo.png') }}">
                </div>

                <div class="links">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/home') }}">Seus dados</a><br>
                        @else
                            <a href="{{ route('login') }}">Entrar</a><br><br>
                            <a href="{{ route('register') }}">Cadastrar</a><br>
                        @endauth
                    @endif
                    <hr>
                    <a href="{{ url('/produtos') }}">Vittalecas</a><br>
                    <a href="{{ url('/vittalecas/oquesao') }}">O que são as Vittalecas?</a><br>
                    <a href="{{ url('/vittalecas/regulamento') }}">Regulamento</a>
                </div>
            </div>
        </div>
    </body>
</html>

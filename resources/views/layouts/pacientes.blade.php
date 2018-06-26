<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title or config('app.name') }}</title>
    
    <link rel="shortcut icon" href="{{ url('/public/img/logo.png') }}" />
    <link href="{{ url('/public/img/logo.png') }}" />
    <link href="{{ url('/public/img/logo.png') }}" sizes="152x152" />
    <link href="{{ url('/public/img/logo.png') }}" sizes="167x167" />
    <link href="{{ url('/public/img/logo.png') }}" sizes="180x180" />
    <link href="{{ url('/public/img/logo.png') }}" rel="icon" sizes="192x192" />
    <link href="{{ url('/public/img/logo.png') }}" rel="icon" sizes="128x128" />


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="https://clinicavittagoiania.com.br/" style="font-family: 'Indie Flower', cursive;">{{ $title or config('app.name') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#">Resultados de exames</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <br><br>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CyphTrader') }}</title>

    @if(env('APACHE', true))
        <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @endif


</head>
<body class="bg-blue-grey-darken-4">
<div id="app">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'CyphTrader') }} - Homebroker
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if (Auth::user()->cargo >= 2)
                                    <a class="dropdown-item" href="{{ url('administrativo') }}">Administrativo</a>
                                @endif
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div id="app">
            <notificacao></notificacao>
            <div class="container">
                <br>
                @if (!empty(session()->get('resultado')) && session()->get('resultado')['resultado'])
                    @if (empty(session()->get('resultado')['mensagem']))
                        <notificacao mensagem="Operação realizada com sucesso!" tipo="success"></notificacao>
                        {{--<div class="alert alert-success">
                            <p><strong>Operação realizada com sucesso!</strong></p>
                        </div>--}}
                    @else
                        <notificacao mensagem="{{ session()->get('resultado')['mensagem'] }}" tipo="success"></notificacao>
                        {{--<div class="alert alert-success">
                            <p><strong>{{ session()->get('resultado')['mensagem'] }}</strong></p>
                        </div>--}}
                    @endif
                @endif

                @if (!empty(session()->get('resultado'))  && !session()->get('resultado')['resultado'])
                    @if (empty(session()->get('resultado')['mensagem']))
                        <notificacao mensagem="Ocorreu um erro ao realizar a operação." tipo="error"></notificacao>
                    @else
                        <notificacao mensagem="{{ session()->get('resultado')['mensagem'] }}" tipo="error"></notificacao>
                    @endif

                @endif
            </div>
            @yield('content')
        </div>
    </main>
</div>
<!-- Scripts -->
@if(env('APACHE', true))
    <script src="{{ asset('public/js/app.js') }}" defer></script>
@else
    <script src="{{ asset('js/app.js') }}" defer></script>
@endif

<!-- FontAwesome -->
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>

<script>
    $(function () {
        $('select').selectpicker();
    });
</script>

@yield('script')
</body>
</html>
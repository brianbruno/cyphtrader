<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CyphTrader') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
    <header>
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'CyphTrader') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

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
        <div class="container-fluid" id="app">

            <div class="container">
                <br>
                @if (!empty($resultado)  && $resultado['resultado'])
                    @if (empty($resultado['mensagem']))
                        <div class="alert alert-success">
                            <p><strong>Operação realizada com sucesso!</strong></p>
                        </div>
                    @else
                        <div class="alert alert-success">
                            <p><strong>{{ $resultado['mensagem'] }}</strong></p>
                        </div>
                    @endif
                @endif

                @if (!empty($resultado)  && !$resultado['resultado'])
                    @if (empty($resultado['mensagem']))
                        <div class="alert alert-success">
                            <p><strong>Ocorreu um erro ao realizar a operação!</strong></p>
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <p><strong>{{ $resultado['mensagem'] }}</strong></p>
                        </div>
                    @endif

                @endif
            </div>
            @yield('content')
        </div>
    </main>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<!-- FontAwesome -->
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>

<script>
    $(function () {
        $('select').selectpicker();
    });
</script>
</body>
</html>
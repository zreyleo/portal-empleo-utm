<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UTM - Tesis</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    {{-- other css files --}}
    @yield('external-css')

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <nav class="navbar navbar-light bg-primary text-white navbar-utm">
        <a class="navbar-brand text-white" href="{{ route('landing') }}">Portal Empleo</a>

        <div>
            <a class="text-white" href="{{ route('login.empresas_get') }}">Empresas</a>
            <a class="text-white mx-5" href="{{ route('login.estudiantes_get') }}">Estudiantes</a>
            <a class="text-white" href="{{ route('login.responsables_get') }}">Docentes</a>
            <a class="text-white ml-5" href="{{ route('login.departamentos_get') }}">Departamentos UTM</a>
        </div>
    </nav>

    @if (session('status'))
        <div id="notificacion" data-mensaje="{{ session('status') }}"  data-clase="bg-success"></div>
    @endif

    <div class="container">

        @yield('guest-content')

    </div>

    {{-- other js files --}}
    @yield('external-js')

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>

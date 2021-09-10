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

    <nav class="navbar navbar-light bg-primary text-white">
        <a class="navbar-brand" href="{{ route('landing') }}">Portal Empleo</a>

        <div>
            <a class="text-white" href="{{ route('new_empresas.create') }}">Registro Nuevas Empresas</a>
            <a class="text-white" href="{{ route('login.empresas_get') }}">Login Empresas</a>
            <a class="text-white" href="{{ route('login.estudiantes_get') }}">Login Estudiantes</a>
        </div>
    </nav>

    <div class="container">

        @yield('guest-content')

    </div>

    {{-- other js files --}}
    @yield('external-js')

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>

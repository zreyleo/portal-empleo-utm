<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Portal Empleo</title>

    {{-- FontAwesome --}}
    <script
        src="https://kit.fontawesome.com/9dd4fe7b9b.js"
        crossorigin="anonymous"
    ></script>

    {{-- other css files --}}
    @yield('external-css')

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @if (session('status'))
        <div id="notificacion" data-mensaje="{{ session('status') }}"  data-clase="bg-success"></div>
    @endif

    @if ($errors->any())
        <div id="notificacion" data-mensaje="{{ $errors->all()[0] }}" data-clase="bg-danger"></div>
    @endif

    <div id="app">
        {{-- Contenido las paginas --}}
        @yield('contenido')
    </div>

    {{-- other js files --}}
    @yield('external-js')

    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

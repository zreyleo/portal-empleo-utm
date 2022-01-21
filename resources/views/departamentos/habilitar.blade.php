@extends('login.base')

@section('login_form')

    @if (session('status'))
        <div id="notificacion" data-mensaje="{{ session('status') }}"  data-clase="bg-success"></div>
    @endif

    <h2 class="text-center my-5">Habilitar Registro de Departamento Interno De La Universidad</h2>

    <div id="buscar-personal" class="row"
        data-ruta-buscar="{{ route('personal.index') }}"
        data-email="{{ $email }}"
        data-ruta-registro="{{ route('departamentos.habilitar', ['token' => $token]) }}"
        data-token="{{ csrf_token() }}"
    ></div>
@endsection

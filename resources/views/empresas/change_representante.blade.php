@extends('empresas.dashboard')

@section('page-content')

<h2 class="text-center my-3">Cambiar Representante</h2>

<div id="cambiar-representante" class="row mb-3"
    data-ruta-exito="{{ route('empresas.informacion') }}"
    data-ruta-base="{{ route('representantes.index') }}"
    data-ruta-registro="{{ route('representantes.registrar') }}"
    data-csrf="{{ csrf_token() }}"
></div>

@endsection

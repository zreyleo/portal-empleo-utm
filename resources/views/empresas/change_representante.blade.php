@extends('empresas.dashboard')

@section('page-content')

<h2 class="text-center my-3">Cambiar Representante</h2>

<div id="cambiar-representante" class="row"
    data-ruta-exito="{{ route('empresas.informacion') }}"
    data-ruta-base="{{ route('representantes.index') }}"
></div>

@endsection

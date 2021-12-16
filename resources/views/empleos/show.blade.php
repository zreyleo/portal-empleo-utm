@extends('empresas.dashboard')

@section('page-content')

<a href="{{ url()->previous() }}" class="btn btn-secondary my-3">Volver</a>

<h1 class="text-center my-5">{{ $empleo->titulo }}</h1>

<div class="row">
    <div class="col-md-6">
        <p><strong>Empresa: </strong> {{ $empleo->empresa->nombre_empresa }}</p>

        <p><strong>&Aacute;rea: </strong> {{ $empleo->escuela->facultad->nombre }}</p>

        <p><strong>Carrera: </strong>
            {{ $carrera }}
        </p>

        <p><strong>Fecha de creaci&oacute;n:</strong> {{ $empleo->created_at->format('d/m/Y') }}</p>
    </div>

    <div class="col-md-6">
        <p><strong>Requerimientos: </strong></p>
        <div class="practicas-requerimientos">
            {!! $empleo->requerimientos !!}
        </div>
    </div>
</div>

@endsection


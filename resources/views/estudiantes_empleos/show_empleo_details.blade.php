@extends('estudiantes.dashboard')

@section('page-content')

    <div class="row">
        <div class="col-md-6">
            <p><strong>Empresa: </strong> {{ $empleo->empresa->nombre_empresa }}</p>

            <p><strong>&Aacute;rea: </strong> {{ $empleo->escuela->facultad->nombre }}</p>

            <p><strong>Carrera: </strong>
                {{ $empleo->escuela->nombre }}
            </p>

            <p><strong>Fecha de creaci&oacute;n:</strong> {{ $empleo->created_at->format('d/m/Y') }}</p>
        </div>

        <div class="col-md-6">
            <p><strong>T&iacute;tulo de la oferta: </strong>{{ $empleo->titulo }}</p>
            <p><strong>Requerimientos: </strong></p>
            <div class="practicas-requerimientos">
                {!! $empleo->requerimientos !!}
            </div>
        </div>
    </div>

@endsection

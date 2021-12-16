@extends('estudiantes.dashboard')

@section('page-content')

    {{-- {{ $practica }} --}}

    <div class="w-full d-flex justify-content-between">
        <a href="{{ route('empleos.show_empleos_offers') }}" class="btn btn-secondary my-3">Volver</a>

        <form action="{{ route('estudiantes_empleos.store', ['empleo' => $empleo->id]) }}" method="post">
            @csrf
            <input type="submit" class="btn btn-primary my-3" value="Postular">
        </form>
    </div>

    <h1 class="text-center">{{ $empleo->titulo }}</h1>

    {{-- <p><strong>Empresa: </strong> {{ $empleo->empresa->nombre_empresa }}</p>
    <p><strong>Carrera: </strong>
        {{ $empleo->escuela->nombre }}
    </p>
    <p><strong>Creacion de Oferta: </strong> {{ $empleo->created_at->format('d/m/Y') }}</p>

    <div class="practicas-requerimientos">
        {!! $empleo->requerimientos !!}
    </div> --}}

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
            <p><strong>Requerimientos: </strong></p>
            <div class="practicas-requerimientos">
                {!! $empleo->requerimientos !!}
            </div>
        </div>
    </div>

@endsection

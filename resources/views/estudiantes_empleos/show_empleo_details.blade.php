@extends('estudiantes.dashboard')

@section('page-content')

    {{-- {{ $practica }} --}}

    <div class="w-full d-flex justify-content-between">
        <a href="{{ route('estudiantes_empleos.index') }}" class="btn btn-outline-danger my-3">Volver</a>
    </div>

    <h1 class="text-center">{{ $empleo->titulo }}</h1>

    <p><strong>Empresa: </strong> {{ $empleo->empresa->nombre_empresa }}</p>
    <p><strong>Carrera: </strong>
        {{ $empleo->escuela->nombre }}
    </p>
    <p><strong>Creacion de Oferta: </strong> {{ $empleo->created_at->format('d/m/Y') }}</p>

    <div>
        {!! $empleo->requerimientos !!}
    </div>

@endsection

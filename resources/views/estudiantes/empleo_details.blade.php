@extends('estudiantes.dashboard')

@section('page-content')

    {{-- {{ $practica }} --}}

    <div class="w-full d-flex justify-content-between">
        <a href="{{ route('estudiantes.empleos_offers') }}" class="btn btn-outline-danger my-3">Volver</a>

        {{-- <form action="{{ route('estudiantes_practicas.store', ['practica' => $practica->id]) }}" method="post">
            @csrf
            <input type="submit" class="btn btn-outline-primary my-3" value="Reservar un cupo">
        </form> --}}
    </div>

    <h1 class="text-center">{{ $empleo->titulo }}</h1>

    <p><strong>Empresa: </strong> {{ $empleo->empresa->nombre_empresa }}</p>
    <p><strong>Carrera: </strong>
        {{ $empleo->escuela->nombre }}
    </p>
    <p><strong>Creacion de Oferta: </strong> {{ $empleo->created_at->format('d/m/Y') }}</p>

    <div class="practicas-requerimientos">
        {!! $empleo->requerimientos !!}
    </div>

@endsection

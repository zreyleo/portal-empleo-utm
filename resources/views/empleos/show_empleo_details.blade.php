@extends('estudiantes.dashboard')

@section('page-content')

    {{-- {{ $practica }} --}}

    <div class="w-full d-flex justify-content-between">
        <a href="{{ route('empleos.show_empleos_offers') }}" class="btn btn-outline-danger my-3">Volver</a>

        <form action="{{ route('estudiantes_empleos.store', ['empleo' => $empleo->id]) }}" method="post">
            @csrf
            <input type="submit" class="btn btn-outline-primary my-3" value="Postular">
        </form>
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
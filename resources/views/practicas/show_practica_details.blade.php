@extends('estudiantes.dashboard')

@section('page-content')

    {{-- {{ $practica }} --}}

    <div class="w-full d-flex justify-content-between">
        <a href="{{ route('practicas.show_practicas_offers') }}" class="btn btn-secondary my-3">Volver</a>

        <form action="{{ route('estudiantes_practicas.store', ['practica' => $practica->id]) }}" method="post">
            @csrf
            <input type="submit" class="btn btn-primary my-3" value="Reservar un cupo">
        </form>
    </div>

    <h1 class="text-center">{{ $practica->titulo }}</h1>

    <div class="row mt-3">
        <div class="col-md-5">
            <p><strong>Empresa: </strong> {{ $practica->empresa->nombre_empresa }}</p>
            <p><strong>Area: </strong>{{ $practica->facultad->nombre }}</p>
            <p><strong>Creacion de Oferta: </strong> {{ $practica->created_at->format('d/m/Y') }}</p>

        </div>

        <div class="col-md-7">
            <p><strong>Requerimientos: </strong></p>

            <div class="practicas-requerimientos">
                {!! $practica->requerimientos !!}
            </div>
        </div>
    </div>

@endsection

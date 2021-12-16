@extends('empresas.dashboard')

@section('page-content')

{{-- {{ $practica }} --}}

<a href="{{ route('practicas.index') }}" class="btn btn-secondary my-3">Volver</a>

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


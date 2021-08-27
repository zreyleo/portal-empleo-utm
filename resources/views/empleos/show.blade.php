@extends('empresas.dashboard')

@section('page-content')

{{-- {{ $empleo }} --}}

<a href="{{ url()->previous() }}" class="btn btn-outline-danger my-3">volver</a>

<h1 class="text-center my-5">{{ $empleo->titulo }}</h1>

<p><strong>Empresa: </strong> {{ $empleo->empresa->nombre_empresa }}</p>
<p><strong>Carrera: </strong>
    {{ $carrera }}
</p>
<p><strong>Fecha de creaci&oacute;n:</strong> {{ $empleo->created_at->format('d/m/Y') }}</p>

<div class="practicas-requerimientos">
    {!! $empleo->requerimientos !!}
</div>

@endsection


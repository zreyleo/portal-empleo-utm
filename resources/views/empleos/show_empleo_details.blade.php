@extends('estudiantes.dashboard')

@section('page-content')

    <div class="w-full d-flex justify-content-between my-3">
        <a href="{{ route('empleos.show_empleos_offers') }}" class="btn btn-secondary">Volver</a>

        @if ($empleo->visible)
            <form action="{{ route('estudiantes_empleos.store', ['empleo' => $empleo->id]) }}" method="post">
                @csrf
                <input type="submit" class="btn btn-primary" value="Postular">
            </form>
        @else
            <button disabled class="btn btn-outline-danger">Esta Oferta ya no Acepta Aspirantes</button>
        @endif

    </div>

    <h1 class="text-center">{{ $empleo->titulo }}</h1>

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

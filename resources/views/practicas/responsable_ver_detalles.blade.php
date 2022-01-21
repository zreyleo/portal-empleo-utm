@extends('responsables.dashboard')

@section('page-content')

    {{-- {{ $practica }} --}}

    <div class="w-full d-flex justify-content-between">
        <a href="{{ route('responsables.practicas') }}" class="btn btn-secondary my-3">Volver</a>

    </div>

    <h1 class="text-center">{{ $practica->titulo }}</h1>

    <div class="row mt-3">
        <div class="col-md-5">
            <p><strong>Empresa: </strong> {{ $practica->empresa->nombre_empresa }}</p>
            <p><strong>Area: </strong>{{ $practica->facultad->nombre }}</p>
            <p><strong>Creacion de Oferta: </strong> {{ $practica->created_at->format('d/m/Y') }}</p>

            <table class="table">
                <thead>
                    <tr>
                        <th>Participantes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($practica->estudiantes_practicas as $estudiante_practica)
                        <tr>
                            <td>{{ $estudiante_practica->personal->nombres_completos }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="1">No Hay Participantes</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

        <div class="col-md-7">
            <p><strong>Requerimientos: </strong></p>

            <div class="practicas-requerimientos">
                {!! $practica->requerimientos !!}
            </div>
        </div>
    </div>

@endsection

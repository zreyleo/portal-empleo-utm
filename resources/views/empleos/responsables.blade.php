@extends('responsables.dashboard')

@section('page-content')

<h2 class="text-center my-3">Reporte de Empleos</h2>

<a href="{{ route('estadisticas.tabla-empleos') }}" class="btn btn-info my-5">Descargar Información de las postulaciones de Empleo</a>

<table class="table">
    <thead>
        <tr>
            <th>Título</th>
            <th>Empresa</th>
            <th>Aspirantes</th>
            <th>Fecha de Creación</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($escuelas as $escuela)

            <tr>
                <td colspan="4" class="text-center font-weight-bold">{{ $escuela->nombre }}</td>
            </tr>

            @forelse ($escuela->empleos as $empleo)

                <tr>
                    <td>{{ $empleo->titulo }}</td>
                    <td>{{ $empleo->empresa->nombre_empresa }}</td>
                    <td>{{ $empleo->estudiantes_empleos->count() }}</td>
                    <td>{{ $empleo->created_at->format('Y/m/d') }}</td>
                </tr>

            @empty

                <tr>
                    <td colspan="4">No hay ofertas de empleo para la CARRERA {{ $escuela->nombre }}</td>
                </tr>

            @endforelse

        @endforeach

    </tbody>
</table>

@endsection

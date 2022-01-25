@extends('responsables.dashboard')

@section('page-content')

<h2 class="text-center my-3">Estad&iacute;sticas de PPP</h2>

{{-- {{ var_dump($practicas) }} --}}

<a href="{{ route('estadisticas.tabla') }}" class="btn btn-info my-5">Descargar Información de la Reservas de Prácticas</a>

<table class="table">
    <thead>
        <tr>
            <th>Título</th>
            <th>Empresa</th>
            <th>Aspirantes</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($practicas as $practica)
            <tr>
                <td>{{ $practica->titulo }}</td>
                <td>{{ $practica->empresa->nombre_empresa }}</td>
                <td>{{ $practica->estudiantes_practicas->count() }} / {{ $practica->cupo }}</td>
                <td>
                    <a href="{{ route('responsables.practicas_ver_detalles', ['practica' => $practica->id]) }}"
                        class="btn btn-success"
                    >Ver</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">No hay Ofertas de Prácticas para su facultad</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection

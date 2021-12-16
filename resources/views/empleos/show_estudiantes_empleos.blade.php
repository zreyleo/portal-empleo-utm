@extends('empresas.dashboard')

@section('page-content')

    <a href="{{ route('empleos.index') }}" class="btn btn-secondary my-3">Volver</a>

    <h2 class="my-2 text-center">Aspirantes</h2>

    <p>Oferta: {{ $empleo->titulo }}</p>

    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">C&eacute;dula</th>
                    <th scope="col">Nombres Completo</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($estudiantes_empleos as $estudiante_empleo)

                    <tr>
                        <td scope="row">{{ $estudiante_empleo->personal->cedula }}</td>
                        <td>{{ $estudiante_empleo->personal->nombres_completos }}</td>
                        <td>
                            @if ($estudiante_empleo->estado == 'ACEPTADO')
                                <span class="badge bg-success text-white">Candidato</span>
                            @else
                                <span class="badge bg-secondary text-white">Pendiente</span>
                            @endif
                        </td>
                        <td class="d-flex">
                            <a href="{{ route('estudiantes_empleos.show_estudiante_data', ['estudiante_empleo' => $estudiante_empleo->id]) }}"
                                class="btn btn-info"
                            >
                                Ver Datos
                            </a>
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="4">No hay aspirantes</td>
                    </tr>

                @endforelse
            </tbody>
        </table>

    </div>

@endsection

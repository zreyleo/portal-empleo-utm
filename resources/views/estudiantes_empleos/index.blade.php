@extends('estudiantes.dashboard')

@section('page-content')
    <h2 class="text-center my-5">Mis Postulaciones de Empleo</h2>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Fecha de Postulaci&oacute;n</th>
                <th scope="col">Titulo</th>
                <th scope="col">Empresa</th>
                <th scope="col">Estado</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>

            @forelse ($estudiantes_empleos as $estudiante_empleo)

                <tr>
                    <td>{{ $estudiante_empleo->created_at->format('Y/m/d') }}</td>
                    <td>{{ $estudiante_empleo->empleo->titulo }}</td>
                    <td>{{ $estudiante_empleo->empleo->empresa->nombre_empresa }}</td>
                    <td>
                        @switch($estudiante_empleo->estado)
                            @case('ACEPTADO')
                                <span class="badge bg-primary text-white">Candidato</span>
                                @break
                            @case('RECHAZADO')
                                <span class="badge bg-danger text-white">No Avanzar&aacute;</span>
                                @break
                            @default
                                <span class="badge bg-secondary text-white">Pendiente</span>
                        @endswitch
                    </td>
                    <td class="d-flex">


                        {{-- <form
                            action="{{ route('estudiantes_empleos.destroy', ['estudiante_empleo' => $estudiante_empleo->id]) }}"
                            method="post" onsubmit="
                            if (!confirm('Desea Eliminar?')) {
                                event.preventDefault();
                                return;
                            }
                        ">
                            @csrf
                            @method('DELETE')

                            <input type="submit" value="Eliminar" class="btn btn-danger">
                        </form> --}}
                        @if ($estudiante_empleo->estado != 'RECHAZADO')
                            <a href="{{ route('estudiantes_empleos.show_empleo_details', ['estudiante_empleo' => $estudiante_empleo->id]) }}"
                                class="btn btn-success mr-2">Ver Detalles</a>

                            <div class="formulario-eliminar"
                                data-ruta="{{ route('estudiantes_empleos.destroy', ['estudiante_empleo' => $estudiante_empleo->id]) }}"
                                data-csrf="{{ csrf_token() }}"
                            ></div>
                        @else
                            <button class="btn btn-outline-danger" disabled>No se puede hacer acciones</button>
                        @endif
                    </td>
                </tr>

            @empty

                <tr>
                    <td class="3">No tienes postulaciones de empleo</td>
                </tr>

            @endforelse
        </tbody>
    </table>

@endsection

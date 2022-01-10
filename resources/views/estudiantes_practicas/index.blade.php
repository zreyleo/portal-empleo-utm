@extends('estudiantes.dashboard')

@section('page-content')

{{-- {{$practicas}} --}}

<h2 class="text-center my-5">Mis Reservaciones de Pr&aacute;cticas</h2>

{{-- {{ $estudiantes_practicas }} --}}

<table class="table">
    <thead>
        <tr>
            <th scope="col">Titulo</th>
            <th scope="col">Empresa</th>
            <th scope="col">Estado</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>
    <tbody>
       @forelse($estudiantes_practicas as $estudiante_practica)

        <tr>
            <td>{{ $estudiante_practica->practica->titulo }}</td>
            <td>{{ $estudiante_practica->practica->empresa->nombre_empresa }}</td>
            <td>
                @switch($estudiante_practica->pasantia->estado)
                    @case(0)
                        @if (!$estudiante_practica->pasantia->fecha_inicio)
                            {{-- <span class="badge bg-info text-black">Completar Datos</span> --}}
                            <a href="http://192.168.112.21/pasantias/"
                                target="_blank"
                                class="btn btn-info"
                            >Completar Datos</a>
                        @else
                            <span class="badge bg-secondary text-white">Pendiente</span>
                        @endif
                        @break
                    @case(1)
                    <span class="badge bg-warning text-black">Ejecutando</span>
                        @break
                    @case(2)
                    <span class="badge bg-success text-black">Finalizado</span>
                        @break
                    @case(3)
                    <span class="badge bg-danger text-white">Finalizado</span>
                        @break
                    @case(4)
                    <span class="badge bg-dark text-white">Anulado</span>
                        @break
                    @default
                    <span class="badge bg-info text-black">Desconocido</span>
                @endswitch
            </td>
            <td class="d-flex">
                {{-- si no es reprobado o anulado --}}
                @if ($estudiante_practica->pasantia->estado <= 2)
                    <a href="{{ route('estudiantes_practicas.show_practica_details', ['estudiante_practica' => $estudiante_practica->id]) }}"
                        class="btn btn-success"
                    >Ver Detalles</a>

                    <a
                        href="{{
                            route('estudiantes_practicas.show_empresa_contact_info', ['estudiante_practica' => $estudiante_practica])
                        }}"
                        class="btn btn-info text-white mx-2 d-flex align-items-center"
                    >
                        Contacto
                    </a>
                @endif

                {{-- <form action="{{ route('estudiantes_practicas.destroy', ['estudiante_practica' => $estudiante_practica->id]) }}"
                    method="post"
                    onsubmit="
                        if (!confirm('Desea Eliminar?')) {
                            event.preventDefault();
                            return;
                        }
                    "
                >
                    @csrf
                    @method('DELETE')

                    <input type="submit" value="Eliminar" class="btn btn-danger">
                </form> --}}

                {{-- si el estado es distinto a 0 que es pendiente no puede eliminar --}}
                @if ($estudiante_practica->pasantia->estado != 0)
                    <button class="btn btn-outline-danger" disabled>No se puede eliminar</button>
                @else
                    <div class="formulario-eliminar"
                        data-ruta="{{ route('estudiantes_practicas.destroy', ['estudiante_practica' => $estudiante_practica->id]) }}"
                        data-csrf="{{ csrf_token() }}"
                    ></div>
                @endif
            </td>
        </tr>

        @empty

        <tr>
            <td colspan="4">No se ha resevado ninguna pr&aacute;ctica</td>
        </tr>

       @endforelse
    </tbody>
</table>

@endsection

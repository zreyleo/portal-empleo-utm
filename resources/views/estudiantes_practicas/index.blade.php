@extends('estudiantes.dashboard')

@section('page-content')

{{-- {{$practicas}} --}}

<h2 class="text-center my-5">Mis Reservaciones de Pr&aacute;cticas</h2>

@if (session('status'))
    <div id="notificacion" data-mensaje="{{ session('status') }}"  data-clase="bg-success"></div>
@endif

{{-- {{ $estudiantes_practicas }} --}}

<table class="table">
    <thead>
        <tr>
            <th scope="col">Titulo</th>
            <th scope="col">Cupo</th>
            <th scope="col">Empresa</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>
    <tbody>
       @forelse($estudiantes_practicas as $estudiante_practica)

        <tr>
            <td>{{ $estudiante_practica->practica->titulo }}</td>
            <td>{{ $estudiante_practica->practica->cupo }}</td>
            <td>{{ $estudiante_practica->practica->empresa->nombre_empresa }}</td>
            <td class="d-flex">
                <a href="{{ route('estudiantes_practicas.show_practica_details', ['estudiante_practica' => $estudiante_practica->id]) }}"
                    class="btn btn-success"
                >Ver Detalles</a>

                <a
                    href="{{
                        route('estudiantes_practicas.show_empresa_contact_info', ['estudiante_practica' => $estudiante_practica])
                    }}"
                    class="btn btn-info text-white mx-2"
                >
                    Contacto
                </a>

                <form action="{{ route('estudiantes_practicas.destroy', ['estudiante_practica' => $estudiante_practica->id]) }}"
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
                </form>
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

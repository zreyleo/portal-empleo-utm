@extends('estudiantes.dashboard')

@section('page-content')

{{-- {{$practicas}} --}}

<h2 class="text-center my-5">Mis Pr&aacute;cticas</h2>

{{-- {{ $estudiantes_practicas }} --}}

@if (session('status'))
    <div id="notificacion-dashboard" data-notificacion="{{ json_encode(session('status')) }}"></div>
@endif

<table class="table">
    <thead>
        <tr>
            <th scope="col">Titulo</th>
            <th scope="col">Cupo</th>
            <th scope="col">Opciones</th>
        </tr>
    </thead>
    <tbody>
       @foreach ($estudiantes_practicas as $estudiante_practica)

        <tr>
            <td>{{ $estudiante_practica->practica->titulo }}</td>
            <td>{{ $estudiante_practica->practica->cupo }}</td>
            <td class="d-flex">
                <a href="{{ route('estudiantes.practica_details_for_estudiante', ['practica' => $estudiante_practica->practica->id]) }}"
                    class="btn btn-success"
                >Ver</a>
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

       @endforeach
    </tbody>
</table>

@endsection

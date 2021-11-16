@extends('estudiantes.dashboard')

@section('page-content')
    <h2 class="text-center my-5">Mis Postulaciones de Empleo</h2>

    @if (session('status'))
        <div id="notificacion" data-mensaje="{{ session('status') }}"  data-clase="bg-success"></div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Titulo</th>
                <th scope="col">Empresa</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estudiantes_empleos as $estudiante_empleo)



            @endforeach

            @forelse ($estudiantes_empleos as $estudiante_empleo)

                <tr>
                    <td>{{ $estudiante_empleo->empleo->titulo }}</td>
                    <td>{{ $estudiante_empleo->empleo->empresa->nombre_empresa }}</td>
                    <td class="d-flex">
                        <a href="{{ route('estudiantes_empleos.show_empleo_details', ['estudiante_empleo' => $estudiante_empleo->id]) }}"
                            class="btn btn-success mr-2">Ver Detalles</a>

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

                        <div class="formulario-eliminar"
                            data-ruta="{{ route('estudiantes_empleos.destroy', ['estudiante_empleo' => $estudiante_empleo->id]) }}"
                            data-csrf="{{ csrf_token() }}"
                        ></div>
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

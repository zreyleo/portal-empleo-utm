@extends('empresas.dashboard')

@section('page-content')

    <a href="{{ route('empleos.create') }}" class="btn btn-primary my-3">Crear Oferta de empleo</a>

    <h2 class="my-5 text-center">Tus Ofertas de Empleo</h2>

    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Aspirantes</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($empleos as $empleo)

                    <tr>
                        <td scope="row">{{ $empleo->id }}</td>
                        <td>{{ $empleo->titulo }}</td>
                        <td>{{ $empleo->estudiantes_empleos->count() }}</td>

                        <td>
                            @if ($empleo->visible)
                                <span class="badge badge-success">Abierta</span>
                            @else
                                <span class="badge badge-warning">Cerrada</span>
                            @endif
                        </td>

                        <td class="d-flex">
                            <a href="{{ route('empleos.show', ['empleo' => $empleo->id]) }}"
                                class="btn btn-success">Ver</a>

                            <a href="{{ route('empleos.edit', ['empleo' => $empleo->id]) }}"
                                class="btn btn-warning mx-2">Editar</a>

                            <a href="{{ route('empleos.show_estudiantes_empleos', ['empleo' => $empleo->id]) }}"
                                class="btn btn-info mr-2">Ver Aspirantes</a>


                            @if ($empleo->visible)
                                <a href="{{ route('empleos.toggleVisible', ['empleo' => $empleo->id]) }}"
                                    class="btn btn-outline-danger mr-2"
                                >Cerrar</a>
                            @else
                                <a href="{{ route('empleos.toggleVisible', ['empleo' => $empleo->id]) }}"
                                    class="btn btn-outline-success mr-2"
                                >Abrir</a>
                            @endif



                            {{-- <form action="{{ route('empleos.destroy', ['empleo' => $empleo->id]) }}" method="POST"
                                onsubmit="
                                    if (!confirm('Desea Eliminar?')) {
                                    event.preventDefault();
                                    }
                                "
                            >
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Eliminar" class="btn btn-danger">
                            </form> --}}

                            <div class="formulario-eliminar"
                                data-ruta="{{ route('empleos.destroy', ['empleo' => $empleo->id]) }}"
                                data-csrf="{{ csrf_token() }}"
                            ></div>
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="4">No ofertas de empleo creadas</td>
                    </tr>

                @endforelse
            </tbody>
        </table>

    </div>

@endsection

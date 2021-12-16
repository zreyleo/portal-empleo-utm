@extends('empresas.dashboard')

@section('page-content')

    <a href="{{ route('practicas.create') }}" class="btn btn-primary my-3">Crear Oferta de pr&aacute;ctica</a>

    <h2 class="my-5 text-center">Tus Ofertas de Pr&aacute;cticas</h2>

    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Aspirantes</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($practicas as $practica)

                    <tr>
                        <td scope="row">{{ $practica->id }}</td>
                        <td>{{ $practica->titulo }}</td>
                        <td>{{ $practica->estudiantes_practicas->count() }}</td>
                        <td>&nbsp;</td>
                        <td class="d-flex">
                            <a href="{{ route('practicas.show', ['practica' => $practica->id]) }}"
                                class="btn btn-success">Ver</a>

                            <a href="{{ route('practicas.edit', ['practica' => $practica->id]) }}"
                                class="btn btn-warning mx-2">Editar</a>
                            {{-- <a href="{{ route('practicas.ver_aspirantes', ['practica' => $practica->id]) }}"
                                class="btn btn-info text-white mr-2">Ver Aspirantes</a> --}}

                            {{-- <form action="{{ route('practicas.destroy', ['practica' => $practica->id]) }}" method="POST"
                                onsubmit="
                                if (!confirm('Desea Eliminar?')) {
                                    event.preventDefault();
                                    return;
                                }
                            ">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Eliminar" class="btn btn-danger">
                            </form> --}}

                            @if ($practica->estudiantes_practicas->count())
                                @if ($practica->pasantias->contains('estado', '>', 0))
                                    <button class="btn btn-outline-danger" disabled>No se puede eliminar</button>
                                @else
                                    <a href="{{ route('practicas.anular', ['practica' => $practica->id]) }}"
                                        class="btn btn-danger">Anular
                                    </a>
                                @endif
                            @else
                                <div class="formulario-eliminar"
                                    data-ruta="{{ route('practicas.destroy', ['practica' => $practica->id]) }}"
                                    data-csrf="{{ csrf_token() }}"
                                ></div>
                            @endif
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="4">No hay ofertas de practica creadas.</td>
                    </tr>

                @endforelse
            </tbody>
        </table>

    </div>

@endsection

@extends('empresas.dashboard')

@section('page-content')

    <h2 class="my-5 text-center">Tus Ofertas de Pr&aacute;cticas</h2>

    {{-- {{ $empleos }} --}}

    @if (session('status'))
        <div id="notificacion" data-mensaje="{{ session('status') }}"  data-clase="bg-success"></div>
    @endif

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
                        {{-- <td>{{ $practica->aspirantes->count() }}</td> --}}
                        <td>&nbsp;</td>
                        <td class="d-flex">
                            <a href="{{ route('practicas.show', ['practica' => $practica->id]) }}"
                                class="btn btn-success">Ver</a>
                            <a href="{{ route('practicas.edit', ['practica' => $practica->id]) }}"
                                class="btn btn-warning mx-2">Editar</a>
                            {{-- <a href="{{ route('practicas.ver_aspirantes', ['practica' => $practica->id]) }}"
                                class="btn btn-info text-white mr-2">Ver Aspirantes</a> --}}
                            <form action="{{ route('practicas.destroy', ['practica' => $practica->id]) }}" method="POST"
                                onsubmit="
                                if (!confirm('Desea Eliminar?')) {
                                    event.preventDefault();
                                    return;
                                }
                            ">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Eliminar" class="btn btn-danger">
                            </form>
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

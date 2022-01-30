@extends('estudiantes.dashboard')

@section('page-content')
    <h2 class="text-center my-5">Ofertas para Empleos para {{ $escuela->nombre }}</h2>

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

            @forelse ($empleos as $empleo)

            <tr>
                <td>{{ $empleo->titulo }}</td>
                <td>{{ $empleo->empresa->nombre_empresa }}</td>
                <td>
                    @if ($empleo->visible)
                        <span class="badge badge-success">Abierta</span>
                    @else
                        <span class="badge badge-warning">Cerrada</span>
                    @endif
                </td>
                <td class="d-flex">
                    <a href="{{ route('empleos.show_empleo_details', ['empleo' => $empleo->id]) }}"
                        class="btn btn-success">Ver</a>
                </td>
            </tr>

            @empty

            <tr>
                <td colspan="3">No hay ofertas de empleo publicadas para {{ $escuela->nombre }}</td>
            </tr>

            @endforelse

            <tr>
                <td colspan="3" class="text-center font-weight-bold">
                    Empleos para toda la FACULTAD DE {{ $facultad->nombre }}
                </td>
            </tr>

            @foreach ($escuelas as $carrera)

                @foreach ($carrera->empleos as $e)

                    <tr>
                        <td>{{ $e->titulo }}</td>
                        <td>{{ $e->empresa->nombre_empresa }}</td>
                        <td>
                            @if ($e->visible)
                                <span class="badge badge-success">Abierta</span>
                            @else
                                <span class="badge badge-warning">Cerrada</span>
                            @endif
                        </td>
                        <td class="d-flex">
                            <a href="{{ route('empleos.show_empleo_details', ['empleo' => $e->id]) }}"
                                class="btn btn-success">Ver</a>
                        </td>
                    </tr>

                @endforeach

            @endforeach

        </tbody>
    </table>

@endsection

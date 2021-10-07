@extends('estudiantes.dashboard')

@section('page-content')
    <h2 class="text-center my-5">Ofertas para Empleos para {{ $escuela->nombre }}</h2>

    @if ($errors->any())
        <div id="notificacion" data-mensaje="{{ $errors->all()[0] }}" data-clase="bg-danger"></div>
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

            @forelse ($empleos as $empleo)

            <tr>
                <td>{{ $empleo->titulo }}</td>
                <td>{{ $empleo->empresa->nombre_empresa }}</td>
                <td class="d-flex">
                    <a href="{{ route('empleos.show_empleo_details', ['empleo' => $empleo->id]) }}"
                        class="btn btn-success">Ver</a>
                </td>
            </tr>

            @empty

            <tr>
                <td colspan="3">No hay ofertas de empleo publicadas</td>
            </tr>

            @endforelse

        </tbody>
    </table>

@endsection

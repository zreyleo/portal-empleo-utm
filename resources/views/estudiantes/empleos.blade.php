@extends('estudiantes.dashboard')

@section('page-content')

    {{-- {{$practicas}} --}}

    <h2 class="text-center my-5">Ofertas para Empleos para {{ $escuela->nombre }}</h2>

    {{-- {{ $practica_ofertas }} --}}

    {{-- @if (session('status'))
    <div id="notificacion" data-notificacion="{{ json_encode(session('status')) }}"></div>
@endif --}}

    @if ($errors->any())
        {{-- {{ $errors->all()[0] }} --}}
        <div id="notificacion" data-mensaje="{{ $errors->all()[0] }}" data-clase="bg-danger">

        </div>
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
                    {{-- <a href="{{ route('estudiantes.practica_details_for_estudiante', ['practica' => $practica->id]) }}"
                        class="btn btn-success">Ver</a> --}}
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

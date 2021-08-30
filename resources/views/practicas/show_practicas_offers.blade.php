@extends('estudiantes.dashboard')

@section('page-content')

    {{-- {{$practicas}} --}}

    <h2 class="text-center my-5">Ofertas para hacer Pr&aacute;cticas Pre Profesionales</h2>

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
                <th scope="col">Cupo</th>
                <th scope="col">Empresa</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($practicas as $practica)

                <tr>
                    <td>{{ $practica->titulo }}</td>
                    <td>{{ $practica->cupo }}</td>
                    <td>{{ $practica->empresa->nombre_empresa }}</td>
                    <td class="d-flex">
                        <a href="{{ route('practicas.show_practica_details', ['practica' => $practica->id]) }}"
                            class="btn btn-success">Ver</a>
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>

@endsection

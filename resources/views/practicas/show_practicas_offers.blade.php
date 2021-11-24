@extends('estudiantes.dashboard')

@section('page-content')

    <h2 class="text-center my-5">Ofertas para hacer Pr&aacute;cticas Pre Profesionales</h2>

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

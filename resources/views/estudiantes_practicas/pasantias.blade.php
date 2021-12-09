@extends('estudiantes.dashboard')

@section('page-content')

<h2 class="text-center my-5">Mis Pr&aacute;cticas</h2>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Empresa</th>
            <th scope="col">Estado</th>
            <th scope="col">horas</th>
            <th scope="col">Detalle</th>
        </tr>
    </thead>
    <tbody>
       @forelse($pasantias as $pasantia)

        <tr>
            <td>{{ $pasantia->empresa->nombre_empresa }}</td>
            <td>
                @switch($pasantia->estado)
                    @case(0)
                    <span class="badge bg-secondary text-white">Pendiente</span>
                        @break
                    @case(1)
                    <span class="badge bg-warning text-black">Ejecutando</span>
                        @break
                    @case(2)
                    <span class="badge bg-success text-white">Finalizado</span>
                        @break
                    @case(3)
                    <span class="badge bg-danger text-white">Reprobado</span>
                        @break
                    @case(4)
                    <span class="badge bg-dark text-white">Anulado</span>
                        @break
                    @default
                    <span class="badge bg-info text-black">Desconocido</span>
                @endswitch
            </td>
            <td>{{ $pasantia->horas }}</td>
            <td>{{ $pasantia->detalle ?: 'SIN DETALLE' }}</td>
        </tr>

        @empty

        <tr>
            <td colspan="4">No se ha hecho solicitudes de pr&aacute;cticas</td>
        </tr>

       @endforelse
    </tbody>
</table>

@endsection

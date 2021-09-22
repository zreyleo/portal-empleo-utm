@extends('responsables.dashboard')


@section('page-content')

{{-- <pre>
    {{ var_dump($nuevas_empresas) }}
</pre> --}}

<h2 class="text-center my-3">Nuevas Empresas</h2>

<div class="row">
    <table class="table">
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Representante</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($nuevas_empresas as $empresa)
                <tr>
                    <td>{{ $empresa->nombre_empresa }}</td>
                    <td>{{ $empresa->representante->nombres_completos }}</td>
                    <td></td>
                </tr>
            @empty

            @endforelse
        </tbody>
    </table>
</div>

@endsection

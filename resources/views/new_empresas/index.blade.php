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
                    <td class="d-flex">
                        <a href="{{ route('new_empresas.show', ['empresa' => $empresa->id_empresa]) }}"
                            class="btn btn-info">Informaci&oacute;n</a>

                        <a href="{{ route('new_empresas.edit', ['empresa' => $empresa->id_empresa]) }}"
                            class="btn btn-warning">Editar</a>

                        <a href="{{ route('new_empresas.reject', ['empresa' => $empresa->id_empresa]) }}"
                            class="btn btn-danger"
                        >
                            Rechazar
                        </a>

                        <form action="{{ route('new_empresas.register', ['nueva_empresa' => $empresa->id_empresa]) }}"
                                method="POST"
                                onsubmit="
                                if (!confirm('Desea Registrar Esta empresa?')) {
                                    event.preventDefault();
                                    return;
                                }
                            ">
                                @csrf
                                <input type="submit" value="Registrar" class="btn btn-success">
                            </form>
                    </td>
                </tr>
            @empty

            @endforelse
        </tbody>
    </table>
</div>

@endsection

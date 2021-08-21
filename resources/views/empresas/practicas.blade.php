@extends('empresas.dashboard')

@section('page-content')

<h2 class="my-3 text-center">Tus Ofertas de Pr&aacute;cticas</h2>

<div class="row">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Titulo</th>
                <th scope="col">Estado</th>
                <th scope="col">Cupo</th>
                <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- <tr>
                <th scope="row">23</th>
                <td>Se necesita programadores</td>
                <td>Activa</td>
                <td>4</td>
                <td></td>
            </tr>
            <tr>
                <th scope="row">25</th>
                <td>Se necesita topografos</td>
                <td>Inactiva</td>
                <td>10</td>
                <td>eliminar</td>
            </tr> --}}
           @foreach ($practicas as $practica)

            <tr>
                <td scope="row">{{ $practica->id }}</td>
                <td>{{ $practica->titulo }}</td>
                <td>
                    @if ($practica->activa)
                        <span class="badge badge-success">Activa</span>
                    @else
                        <span class="badge badge-warning">Inactiva</span>
                    @endif
                </td>
                <td>{{ $practica->cupo }}</td>
                <td class="d-flex">
                    <a href="{{ route('practicas.show', ['practica' => $practica->id]) }}" class="btn btn-success">Mostrar</a>
                    <a href="{{ route('practicas.edit', ['practica' => $practica->id]) }}" class="btn btn-warning mx-2">Editar</a>
                    <form action="{{ route('practicas.destroy', ['practica' => $practica->id]) }}"
                        method="POST"
                        onsubmit="
                            if (!confirm('Desea Eliminar?')) {
                                event.preventDefault();
                            }
                        "
                    >
                        @csrf
                        @method('DELETE')
                        <input 
                            type="submit" 
                            value="Eliminar" 
                            class="btn btn-danger" 
                        >
                    </form>
                </td>
            </tr>

           @endforeach
        </tbody>
    </table>
    
    <pre>
    {{-- @php
        var_dump($empleos)        
    @endphp --}}
    </pre>
</div>

@endsection

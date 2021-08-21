@extends('empresas.dashboard')

@section('page-content')

<h2 class="my-3 text-center"></h2>

{{-- {{ $empleo->aspirantes }} --}}

<div class="row">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">C&Eacute;DULA</th>
                <th scope="col">NOMBRES</th>
                <th scope="col">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
           
            @foreach ($empleo->aspirantes as $aspirante)
                <tr>
                    <td>{{ $aspirante->personal->cedula }}</td>
                    <td>{{ $aspirante->personal->nombre_completo }}</td>
                    <td>
                        <a href="{{ route('empresas.ver_datos_aspirante', [
                            'empleo' => $empleo->id,
                            'aspirante' => $aspirante->personal->cedula
                        ]) }}" class="btn btn-primary">Ver Datos</a>    
                    </td>
                </tr>
            @endforeach
           
        </tbody>
    </table>
    
</div>

@endsection

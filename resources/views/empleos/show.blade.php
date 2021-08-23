@extends('empresas.dashboard')

@section('page-content')

{{-- {{ $empleo }} --}}

<a href="{{ url()->previous() }}" class="btn btn-outline-danger my-3">volver</a>

<h1 class="text-center my-5">{{ $empleo->titulo }}</h1>

<p><strong>Empresa: </strong> {{ $empleo->empresa->nombre_empresa }}</p>
<p><strong>Carrera: </strong>
    @php
        use Carbon\Carbon;

        $id_carrera = $empleo->carrera_id;
        $sql = 'select idescuela, es.nombre
        from esq_inscripciones.escuela es
        where idescuela = :id_carrera';
        $result = DB::connection('DB_db_sga_SCHEMA_esq_inscripciones')->select($sql, [
            'id_carrera' => $id_carrera
        ]);
        // dd($result);

        $carrera = $result[0];
    @endphp
    {{ $carrera->nombre }}
</p>
<p><strong>Fecha de creaci&oacute;n:</strong> {{ Carbon::parse($empleo->created_at)->format('d/m/Y') }}</p>

<div class="practicas-requerimientos">
    {!! $empleo->requerimientos !!}
</div>

@endsection


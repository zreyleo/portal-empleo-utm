@extends('empresas.dashboard')

@section('page-content')

{{-- {{ $practica }} --}}

<a href="{{ route('practicas.index') }}" class="btn btn-outline-danger my-3">volver</a>
<h1 class="text-center">{{ $practica->titulo }}</h1>

<p><strong>Empresa: </strong> {{ $practica->empresa->nombre_empresa }}</p>
<p><strong>Area: </strong> 
    @php
        use Carbon\Carbon;

        $id_facultad = $practica->facultad_id;
        $sql = 'select idfacultad, nombre
        from esq_inscripciones.facultad
        where idfacultad = :id_facultad';
        $result = DB::connection('db_sga')->select($sql, [
            'id_facultad' => $id_facultad
        ]);
        // dd($result)

        $facultad = $result[0];
    @endphp
    {{ $facultad->nombre }}
</p>
<p><strong>Creacion de Oferta: </strong> {{ Carbon::parse($practica->created_at)->format('d/m/Y') }}</p>

<div class="practicas-requerimientos">
    {!! $practica->requerimientos !!}
</div>

@endsection


@extends('estudiantes.dashboard')

@section('page-content')

    {{-- {{ $practica }} --}}

    <div class="w-full d-flex justify-content-between">
        <a href="{{ route('estudiantes.practicas_offers') }}" class="btn btn-outline-danger my-3">volver</a>

        <form action="{{ route('estudiantes_practicas.store', ['practica' => $practica->id]) }}" method="post">
            @csrf
            <input type="submit" class="btn btn-outline-primary my-3" value="Reservar un cupo">
        </form>
    </div>

    <h1 class="text-center">{{ $practica->titulo }}</h1>

    <p><strong>Empresa: </strong> {{ $practica->empresa->nombre_empresa }}</p>
    <p><strong>Area: </strong>
        @php
            use Carbon\Carbon;

            $id_facultad = $practica->facultad_id;
            $sql = 'select idfacultad, nombre
                    from esq_inscripciones.facultad
                    where idfacultad = :id_facultad';
            $result = DB::connection('DB_db_sga_SCHEMA_esq_inscripciones')->select($sql, [
                'id_facultad' => $id_facultad,
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

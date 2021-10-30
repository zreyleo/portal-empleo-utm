@extends('responsables.dashboard')


@section('page-content')

{{-- <pre>
    {{ var_dump($nuevas_empresas) }}
</pre> --}}

<h2 class="text-center my-3">Estad&iacute;sticas de PPP</h2>

<div class="row">
    <div class="col-md-5 pt-3 border border-success">
        <p>Total de ofertas de PPP para la UNIVERSIDAD: <strong>{{ $all_practicas_universidad->count() }}</strong></p>
        <p>Total de ofertas de PPP para la FACULTAD DE {{ $facultad->nombre }}: <strong>{{ $all_practicas_facultad->count() }}</strong></p>

        @if ($all_practicas_universidad->count())
            <p>Porcentaje de PPP para la FACULTAD: <strong>&#37;{{ round((($all_practicas_facultad->count() * 100) / $all_practicas_universidad->count()), 2) }}</strong></p>
        @endif

        @if ($facultad_max_ppp)
            <p>Facultad con mas ofertas de PPP es: <strong>{{ $facultad_max_ppp->nombre }}</strong><br>
                con <strong>{{ $facultad_max_ppp->practicas->count() }}</strong> ofertas
            </p>
        @endif
    </div>

    <div class="col-md-5 pt-3 ml-auto border border-primary">
        <p>Total de reservaciones de PPP de la UNIVERSIDAD: <strong>{{ $estudiantes_practicas_count }}</strong></p>
        <p>Total de reservaciones de PPP a nivel de FACULTAD: <strong>{{ $facultad_estudiantes_practicas_count }}</strong></p>
    </div>
</div>

{{-- <pre>
    {{ var_dump($total_candidatos_facultad) }}
</pre> --}}

@endsection

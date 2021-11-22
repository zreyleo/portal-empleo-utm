@extends('responsables.dashboard')

@section('page-content')

<a href="{{ route('estadisticas.pdf') }}" class="btn btn-info mt-3">Descargar PDF</a>

<h2 class="text-center my-3">Estad&iacute;sticas de PPP</h2>

<div class="row">
    <div class="col-md-6">
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

    <div class="col-md-6">
        <p>Total de reservaciones de PPP de la UNIVERSIDAD: <strong>{{ $estudiantes_practicas_count }}</strong></p>
        <p>Total de reservaciones de PPP a nivel de FACULTAD: <strong>{{ $facultad_estudiantes_practicas_count }}</strong></p>
    </div>
</div>

<h2 class="text-center my-3">Estad&iacute;sticas de Empleos</h2>

<div class="row">
    <div class="col-md-6">
        <p>Total de ofertas de empleo para la UNIVERSIDAD: <strong>{{ $num_empleos_total }}</strong></p>
        <p>Total de ofertas de empleo para la FACULTAD DE {{ $facultad->nombre }}: <strong>{{ $num_empleos_facultad }}</strong></p>

        @if ($num_empleos_total)
            <p>Porcentaje de empleos para la FACULTAD: <strong>&#37;{{ round((($num_empleos_facultad * 100) / $num_empleos_total), 2) }}</strong></p>
        @endif

        @if ($facultad_escuela_max_empleos)
            <p>Escuela con mas ofertas de empleo de la FACULTAD: <strong>{{ $facultad_escuela_max_empleos->nombre }}</strong><br>
                con <strong>{{ $facultad_escuela_max_empleos->empleos->count() }}</strong> ofertas
            </p>
        @endif

        @if ($universidad_escuela_max_empleos)
            <p>Escuela con mas ofertas de empleo de la Universidad: <strong>{{ $universidad_escuela_max_empleos->nombre }}</strong><br>
                con <strong>{{ $universidad_escuela_max_empleos->empleos->count() }}</strong> ofertas
            </p>
        @endif
    </div>

    <div class="col-md-6">
        <p>Total de postulaciones de la UNIVERSIDAD: <strong>{{ $all_estudiantes_empleos }}</strong></p>
        <p>Total de postulaciones consideradas como candidatos para un puesto de trabajo a nivel de UNIVERSIDAD: <strong>{{ $all_estudiantes_empleos_aceptado->count() }}</strong></p>
        <p>Total de postulaciones consideradas como NO candidatos para un puesto de trabajo a nivel de UNIVERSIDAD: <strong>{{ $all_estudiantes_empleos_rechazado->count() }}</strong></p>
        <p>Total de postulaciones de la FACULTAD DE {{ $facultad->nombre }}: <strong>{{ $total_facultad_estudiantes_empleos }}</strong></p>
        <p>Total de postulaciones consideradas como candidatos para un puesto de trabajo a nivel de la FACULTAD DE {{ $facultad->nombre }}: <strong>{{ $total_facultad_estudiantes_empleos_aceptado }}</strong></p>
        <p>Total de postulaciones consideradas como NO candidatos para un puesto de trabajo a nivel de la FACULTAD DE {{ $facultad->nombre }}: <strong>{{ $total_facultad_estudiantes_empleos_rechazado }}</strong></p>
    </div>
</div>

@endsection

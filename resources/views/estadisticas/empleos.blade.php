@extends('responsables.dashboard')


@section('page-content')

{{-- <pre>
    {{ var_dump($nuevas_empresas) }}
</pre> --}}

<h2 class="text-center my-3">Estad&iacute;sticas de Empleos</h2>

<div class="row">
    <div class="col-md-4">
        <p>Total de ofertas de empleo para la UNIVERSIDAD: <strong>{{ $num_empleos_total }}</strong></p>
        <p>Total de ofertas de empleo para la FACULTAD DE {{ $facultad->nombre }}: <strong>{{ $num_empleos_facultad }}</strong></p>
        <p>Porcentaje de empleos para la FACULTAD: <strong>&#37;{{ round((($num_empleos_facultad * 100) / $num_empleos_total), 2) }}</strong></p>
        <p>Escuela con mas ofertas de empleo de la FACULTAD: <strong>{{ $facultad_escuela_max_empleos->nombre }}</strong><br>
            con <strong>{{ $facultad_escuela_max_empleos->empleos->count() }}</strong> ofertas
        </p>
        <p>Escuela con mas ofertas de empleo de la Universidad: <strong>{{ $universidad_escuela_max_empleos->nombre }}</strong><br>
            con <strong>{{ $universidad_escuela_max_empleos->empleos->count() }}</strong> ofertas
        </p>
    </div>
    <div class="col-md-4">
        <p>Total de estudiantes considerados candidatos: <strong>200</strong></p>
    </div>
    <div class="col-md-4"></div>
</div>

@endsection

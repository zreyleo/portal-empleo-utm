@extends('layouts.dashboard')

@section('user')
    {{ $docente['nombres'] }}
@endsection

@section('enlaces')

<li>
    <a href="#empleos" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <i class="fas fa-building"></i>
        Empresas
    </a>
    <ul class="collapse list-unstyled" id="empleos">
        <li>
            <a href="{{ route('new_empresas.index') }}">Nuevas Empresas</a>
        </li>
    </ul>
    <a href="{{ route('estadisticas.all') }}" >
        <i class="far fa-chart-bar"></i>
        Estad&iacute;sticas
    </a>
    <a href="{{ route('responsables.practicas') }}" >
        <i class="fas fa-university"></i>
        Pr&aacute;cticas
    </a>
    {{-- <a href="#estadisticas" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <i class="far fa-chart-bar"></i>
        Estad&iacute;sticas
    </a>

    <ul class="collapse list-unstyled" id="estadisticas">
        <li>
            <a href="{{ route('estadisticas.empleos') }}">Empleos</a>
        </li>
        <li>
            <a href="{{ route('estadisticas.practicas') }}">Pr&aacute;cticas</a>
        </li>
    </ul> --}}
    <a href="#departamentos" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <i class="fas fa-university"></i>
        Departamentos UTM
    </a>
    <ul class="collapse list-unstyled" id="departamentos">
        <li>
            <a href="{{ route('departamentos.create') }}">Registrar</a>
        </li>
    </ul>

</li>

{{-- <li>
    <a href="#practicas" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <i class="fas fa-user-graduate"></i>
        Prácticas
    </a>
    <ul class="collapse list-unstyled" id="practicas">
        <li>
            <a href="{{ route('practicas.show_practicas_offers') }}">Ver Ofertas de Pr&aacute;cticas</a>
        </li>
        <li>
            <a href="{{ route('estudiantes_practicas.index') }}">Ver mis reservaciones de pr&aacute;cticas</a>
        </li>
    </ul>
</li> --}}

@endsection

@section('page-content')

<div class="row mt-3">
    <div class="col-md-8">
        {{-- {{ var_dump($estudiante) }} --}}
        <br>
        <p>
            Bienvenido al Portal de Empleo UTM, como docente responsable de prácticas usted podrá ver las ofertas de PPP
            que hay para sus Facultad y ver cuales son sus participantes.
        </p>
    </div>
    <div class="col-md-4">

    </div>
</div>

@endsection

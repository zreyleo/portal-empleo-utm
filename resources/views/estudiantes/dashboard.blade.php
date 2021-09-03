@extends('layouts.dashboard')

@section('user')
    {{ $estudiante['nombres'] }}
@endsection

@section('enlaces')

<li>
    <a href="{{ route('perfil.show') }}">
        <i class="fas fa-user"></i>
        Perfil
    </a>
    <a href="#empleos" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <i class="fas fa-briefcase"></i>
        Empleos
    </a>
    <ul class="collapse list-unstyled" id="empleos">
        <li>
            <a href="{{ route('empleos.show_empleos_offers') }}">Ofertas de empleo</a>
        </li>
        <li>
            <a href="{{ route('estudiantes_empleos.index') }}">Tus postulaciones</a>
        </li>
    </ul>
</li>

<li>
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
</li>

@endsection

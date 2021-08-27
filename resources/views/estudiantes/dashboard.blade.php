@extends('layouts.dashboard')

@section('user')
    {{ $estudiante['nombres'] }}
@endsection

@section('enlaces')

<li>
    <a href="#empleos" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <i class="fas fa-briefcase"></i>
        Empleos
    </a>
    <ul class="collapse list-unstyled" id="empleos">
        <li>
            <a href="{{ route('empleos.index') }}">Tus ofertas de empleo</a>
        </li>
        <li>
            <a href="{{ route('empleos.create') }}">Crear Oferta de empleo</a>
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
            <a href="{{ route('estudiantes.practicas_offers') }}">Ver Ofertas de Pr&aacute;cticas</a>
        </li>
        <li>
            <a href="{{ route('estudiantes_practicas.index') }}">Ver mis reservaciones de pr&aacute;cticas</a>
        </li>
    </ul>
</li>

@endsection

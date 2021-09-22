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

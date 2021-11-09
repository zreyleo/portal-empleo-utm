@extends('layouts.dashboard')

@section('user')
    {{ $empresa['nombre_empresa'] }}
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
            <a href="{{ route('practicas.index') }}">Tus ofertas de Pr&aacute;cticas</a>
        </li>
        <li>
            <a href="{{ route('practicas.create') }}">Crear Oferta de Pr&aacute;cticas</a>
        </li>
    </ul>
</li>

<li>
    <a href="#empresa" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <i class="fas fa-building"></i>
        Empresa
    </a>
    <ul class="collapse list-unstyled" id="empresa">
        <li>
            <a href="{{ route('empresas.password_edit') }}">Cambiar Password</a>
        </li>
        <li>
            <a href="{{ route('empresas.informacion') }}">Informaci&oacute;n</a>
        </li>
    </ul>
</li>

@endsection

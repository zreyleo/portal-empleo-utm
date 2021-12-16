@extends('layouts.dashboard')

@section('user')
    {{ $empresa['nombre_empresa'] }}
@endsection

@section('enlaces')

<li>
    <a href="{{ route('empresas.dashboard') }}">
        <i class="fas fa-house-user"></i>
        Inicio
    </a>
</li>

<li>
    <a href="#practicas" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <i class="fas fa-university"></i>
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
    <a href="{{ route('empleos.index') }}">
        <i class="fas fa-briefcase"></i>
        Empleos
    </a>
</li>

<li>
    <a href="#empresa" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <i class="fas fa-building"></i>
        Empresa
    </a>
    <ul class="collapse list-unstyled" id="empresa">
        <li>
            <a href="{{ route('empresas.informacion') }}">Informaci&oacute;n</a>
        </li>
        <li>
            <a href="{{ route('empresas.cambiar_representante') }}">Cambiar Representante</a>
        </li>
        <li>
            <a href="{{ route('empresas.password_edit') }}">Cambiar Password</a>
        </li>
    </ul>
</li>

@endsection

@section('page-content')

<div class="row mt-3">
    <div class="col-md-8">
        {{ var_dump($empresa) }}
    </div>
    <div class="col-md-4">
        Instrucciones aqui
    </div>
</div>

@endsection

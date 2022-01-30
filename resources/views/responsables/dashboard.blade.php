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
    <a href="{{ route('responsables.practicas') }}" >
        <i class="fas fa-university"></i>
        Pr&aacute;cticas
    </a>
    <a href="{{ route('responsables.empleos') }}" >
        <i class="fas fa-briefcase"></i>
        Empleos
    </a>

    <a href="#departamentos" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <i class="far fa-building"></i>
        Departamentos UTM
    </a>
    <ul class="collapse list-unstyled" id="departamentos">
        <li>
            <a href="{{ route('departamentos.create') }}">Registrar</a>
        </li>
    </ul>

</li>

@endsection

@section('page-content')

<div class="row mt-3">
    <div class="col-md-8">
        <p>
            Bienvenido al Portal de Empleo UTM, como docente responsable de prácticas usted podrá ver las ofertas de PPP
            que hay para sus Facultad y ver cuales son sus participantes.
        </p>
    </div>
    <div class="col-md-4">
        <div class="alert alert-info">
            <p>Se recomienda no poner en ejecución las práctica hasta recibir confirmación de la empresa</p>
        </div>
    </div>
</div>

@endsection

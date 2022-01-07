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
    <a href="{{ route('empresas.carreras') }}">
        <i class="fas fa-graduation-cap"></i>
        Carreras Disponibles
    </a>
</li>

<li>
    <a href="{{ route('practicas.index') }}">
        <i class="fas fa-university"></i>
        Pr&aacute;cticas
    </a>
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
    <div class="col-md-12">
        {{-- {{ var_dump($empresa) }} --}}

        <h2>Bienvenido al Portal de Empleos UTM</h2>

        <p>Usted puede publicar ofertas de empleo hacia todas las carreras que se estudian en la
            Universidad T&eacute;cnica de Manab&iacute;, que puede consultar
            <a class="text-info underline" style="text-decoration: underline" href="{{ route('empresas.carreras') }}">aqu&iacute;</a>
        </p>

        <p>
            Puede administrar sus ofertas de empleo y pr&aacute;cticas en la barra lateral izquierda.
        </p>

        <p>Cuando los estudiantes postulen a sus ofertas de trabajo, usted tendr&aacute;
            acceso a los datos de contacto del estudiante, ademas podr&aacute; clasificarlos como candidatos.</p>

        <div class="alert alert-info w-75">
            <p>Nota: Si ha publicado ofertas de Pr&aacute;cticas Pre Profesional, pero las desea eliminar,
                tome en cuenta que estas ofertas donde los estudiantes han comenzado a realizar actividades,
                no se podran eliminar.
            </p>
        </div>
    </div>
</div>

@endsection

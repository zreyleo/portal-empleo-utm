@extends('layouts.dashboard')

@section('user')
    {{ $estudiante['nombres'] }}
@endsection

@section('enlaces')

<li>
    <a href="{{ route('estudiantes.dashboard') }}">
        <i class="fas fa-house-user"></i>
        Inicio
    </a>
</li>

<li>
    <a href="{{ route('perfil.show') }}">
        <i class="fas fa-user"></i>
        Perfil
    </a>
</li>

<li>
    <a href="#practicas" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
        <i class="fas fa-university"></i>
        Prácticas
    </a>

    <ul class="collapse list-unstyled" id="practicas">
        <li>
            <a href="{{ route('practicas.show_practicas_offers') }}">Ver Ofertas de Pr&aacute;cticas</a>
        </li>
        <li>
            <a href="{{ route('estudiantes_practicas.index') }}">Ver mis reservaciones de pr&aacute;cticas</a>
        </li>
        <li>
            <a href="{{ route('estudiantes_practicas.get_pasantias') }}">Ver mis Pr&aacute;caticas anteriores</a>
        </li>
    </ul>
</li>

<li>

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

@endsection

@section('page-content')

<div class="row mt-3">
    <div class="col-md-8">
        {{-- {{ var_dump($estudiante) }} --}}
        <br>
        <h2>Bienvenido al Portal de Empleo UTM</h2>

        <p>Como estudiante, podr&aacute;s visualizar las ofertas de empleo que est&aacute;n para tu carrera actualmente.</p>

        <p>Cuentas con un perfil para describir mejor tus capacidades laborales y describir tu experiencia de trabajo,
            lo puedes actualizar
            <a class="text-primary"
                style="text-decoration: underline"
                href="{{ route('perfil.show') }}"
            >aqu&iacute;</a>
        </p>

        <p>Adem&aacute;s, si estas habilitado para registrar horas de
            <span class="text-capitalize">pr&aacute;cticas pre profesional</span>
            podr&aacute;s reservar un cupo de las ofertas de pr&aacute;ctica que est&aacute;n abiertas para tu Facultad
        </p>

        <p>Si logras reservar una práctica con éxito, tendrás que completar los datos que faltan
            <a
                style="text-decoration: underline"
                class="text-primary underline"
                href="https://pasantias.utm.edu.ec/"
                target="__blank"
            >https://pasantias.utm.edu.ec</a>
        </p>
    </div>
    <div class="col-md-4">
        @if (!$estudiante['can_register_ppp'])
            <div class="alert alert-danger">
                <p>Actualmente no estas habilitado para reservar horas de
                    <span class="text-capitalize">pr&aacute;cticas pre profesional</span>
                    por la siguiente raz&oacute;n: <br />
                    @if ($estudiante['is_redesign'])
                        No estas matriculado para registrar horas de pr&aacute;cticas.
                    @else
                        Ya has completado el m&iacute;nimo de horas requeridas en tu carrera.
                    @endif
                </p>

            </div>
        @else
            <div class="alert alert-primary">
                Actualemente puedes registrar horas de pr&aacute;cticas,
                pero ten encuenta que no podr&aacute;s reservar una oferta si ya tienes una pasantia en ejecuci&oacute;n,
                puedes verificar <a class="text-dark underline" style="text-decoration: underline" href="{{ route('estudiantes_practicas.get_pasantias') }}">aqu&iacute;</a>.
            </div>
        @endif
    </div>
</div>

@endsection

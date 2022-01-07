@extends('layouts.guest')

@section('guest-content')

    @if (session('status'))
        <div id="notificacion" data-mensaje="{{ session('status') }}" data-clase="bg-success"></div>
    @endif

    <h1 class="my-5">Bienvenido al Portal Empleos de la Universidad T&eacute;cnica de Manab&iacute;</h1>

    <div class="row">
        <div class="col-md-5 mx-auto">
            <p style="font-size: 20px;" class="text-justify">El objetivo de este portal de empleos es ayudar a los estudiantes de la Universidad T&eacute;cnica de Manab&iacute; a encontrar
                instituciones que les permita realizar pr&aacute;cticas pre profesionales bajo supervisi&oacute;n de estas instituciones, y a su
                vez que las instituciones puedan publicar ofertas de pr&aacute;cticas. </p>
        </div>
        <div class="col-md-5 mx-auto">
            <p style="font-size: 20px;" class="text-justify">Las Prácticas Pre Profesionales son el espacio laboral en donde los estudiantes
                de los últimos niveles, realizan diversas actividades de fortalecimiento y
                aplicación de los conocimientos académicos, demostrando a los empresarios
                privados y a las instituciones públicas las habilidades y capacidades adquiridas
                durante su formación académica. </p>
        </div>
    </div>

@endsection

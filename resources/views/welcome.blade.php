@extends('layouts.guest')

@section('guest-content')

@if (session('status'))
    <div id="notificacion" data-mensaje="{{ session('status') }}"  data-clase="bg-success"></div>
@endif

<h1 class="my-5">Bienvenido al Portal Empleos de la Universidad T&eacute;cnica de Manab&iacute;</h1>

@endsection


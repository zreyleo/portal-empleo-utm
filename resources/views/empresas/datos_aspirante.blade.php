@extends('empresas.dashboard')

@section('page-content')

{{-- {{ var_dump($datos_aspirante) }} --}}

<h2 class="text-center my-3">Datos del aspirante</h2>

<p><strong class="text-uppercase">Nombre completo: </strong>{{ $datos_aspirante->apellido1 }} {{ $datos_aspirante->apellido2 }} {{ $datos_aspirante->nombres }}</p>
<p><strong class="text-uppercase">C&eacute;dula: </strong>{{ $datos_aspirante->cedula }}</p>
<p><strong class="text-uppercase">Tel&eacute;fono: </strong>{{ $datos_aspirante->telefono }}</p>
<p><strong class="text-uppercase">E-mail constitucional: </strong>{{ $datos_aspirante->email_utm }}</p>
<p><strong class="text-uppercase">E-mail personal: </strong>{{ $datos_aspirante->email_alt }}</p>
<p><strong class="text-uppercase">Ubicaci&oacute;n actual: </strong>{{ $datos_aspirante->provincia }} - {{ $datos_aspirante->canton }}</p>

<h3>Datos del trabajo</h3>

@endsection
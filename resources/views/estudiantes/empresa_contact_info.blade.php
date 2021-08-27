@extends('estudiantes.dashboard')

@section('page-content')

{{-- {{ $empresa }} --}}

<h2 class="text-center my-5">Informaci&oacute;n de Contacto</h2>

<p><strong>Nombre de la empresa:</strong> {{ $empresa->nombre_empresa }}</p>
<p><strong>Tel&eacute;fono:</strong> {{ $empresa->telefono }}</p>
<p><strong>E-mail:</strong> {{ $empresa->email }}</p>

<h3 class="my-3">Ubicaci&oacute;n</h3>

<p><strong>Provincia:</strong> {{ $location->provincia }}</p>
<p><strong>Canton:</strong> {{ $location->canton }}</p>
<p><strong>Parroquia:</strong> {{ $location->parroquia }}</p>
<p><strong>Direcci&oacute;n:</strong> {{ $empresa->direccion }}</p>

@endsection

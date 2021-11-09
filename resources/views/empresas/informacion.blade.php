@extends('empresas.dashboard')

@section('page-content')

{{-- {{ $empresa }} --}}

<div class="my-3">
    {{-- <a href="{{ route('estudiantes_practicas.index') }}" class="btn btn-outline-danger">Volver</a> --}}
</div>

<div class="col-md-6">
    <h2 class="text-center my-5">Informaci&oacute;n de Contacto</h2>

    <p><strong>Nombre de la empresa:</strong> {{ $empresa_informacion->nombre_empresa }}</p>
    <p><strong>Tel&eacute;fono:</strong> {{ $empresa_informacion->telefono }}</p>
    <p><strong>E-mail:</strong> {{ $empresa_informacion->email }}</p>

    <h3 class="my-3">Ubicaci&oacute;n</h3>

    {{-- <p><strong>Provincia:</strong> {{ $location->provincia }}</p>
    <p><strong>Canton:</strong> {{ $location->canton }}</p>
    <p><strong>Parroquia:</strong> {{ $location->parroquia }}</p> --}}
    <p><strong>Direcci&oacute;n:</strong> {{ $empresa_informacion->direccion }}</p>
</div>

<div class="col-md-6">
    <h2>Descripci&oacute;n</h2>
    {!! $empresa_informacion->descripcion !!}
</div>

@endsection

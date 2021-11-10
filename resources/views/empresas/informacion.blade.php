@extends('empresas.dashboard')

@section('page-content')

<a href="{{ route('empresas.informacion_edit') }}" class="btn btn-outline-primary my-3">Editar</a>

<div class="row my-5">
    <div class="col-md-6">
        <h2 class="text-center">Informaci&oacute;n de Contacto</h2>

        <p><strong>Nombre de la empresa:</strong> {{ $empresa_informacion->nombre_empresa }}</p>
        <p><strong>RUC:</strong> {{ $empresa_informacion->ruc }}</p>
        <p><strong>Tel&eacute;fono:</strong> {{ $empresa_informacion->telefono }}</p>
        <p><strong>E-mail:</strong> {{ $empresa_informacion->email }}</p>

        <h3 class="my-3">Ubicaci&oacute;n</h3>

        <p><strong>Provincia:</strong> {{ $location->provincia }}</p>
        <p><strong>Canton:</strong> {{ $location->canton }}</p>
        <p><strong>Parroquia:</strong> {{ $location->parroquia }}</p>
        <p><strong>Direcci&oacute;n:</strong> {{ $empresa_informacion->direccion }}</p>

        <h2>Representante</h2>

        <p><strong>C&eacute;dula:</strong> {{ $representante->cedula }}</p>
        <p><strong>Nombre del Representante:</strong> {{ $representante->nombres_completos }}</p>
        <p><strong>T&iacute;tulo:</strong> {{ $representante->titulo }}</p>
    </div>

    <div class="col-md-6">
        <h2>Descripci&oacute;n</h2>
        {!! $empresa_informacion->descripcion !!}
    </div>
</div>

@endsection

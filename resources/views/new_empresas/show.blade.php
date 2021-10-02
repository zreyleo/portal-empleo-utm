@extends('responsables.dashboard')


@section('page-content')

{{-- <pre>
    {{ $empresa }}
</pre> --}}

<a href="{{ route('new_empresas.index') }}" class="btn btn-outline-danger my-3">Volver</a>

<h2 class="text-center my-3">Informaci&oacute;n</h2>

<div class="row">
    <div class="col-md-7">
        <p><strong class="text-uppercase">Nombre de la Empresa: </strong>{{$empresa->nombre_empresa}}</p>
        <p><strong class="text-uppercase">RUC: </strong>{{$empresa->ruc}}</p>
        <p><strong class="text-uppercase">&Aacute;rea: </strong>{{$empresa->facultad->nombre}}</p>
        <p><strong class="text-uppercase">Descripci&oacute;n: </strong></p>
        <div class="descripcion">
            {!! $empresa->descripcion !!}
        </div>
    </div>

    <div class="col-md-5 border p-3">
        <h3>Representante</h3>
        <p><strong class="text-uppercase">Nombre: </strong>{{ $empresa->representante->nombres_completos }}</p>
        <p><strong class="text-uppercase">C&Eacute;dula: </strong>{{$empresa->representante->cedula}}</p>
        <p><strong class="text-uppercase">Cargo en la Empresa: </strong>{{$empresa->representante->titulo}}</p>
        <div>
            <h3>Ubicaci&oacute;n</h3>
            <p><strong>Provincia:</strong> {{ $location->provincia }}</p>
            <p><strong>Canton:</strong> {{ $location->canton }}</p>
            <p><strong>Parroquia:</strong> {{ $location->parroquia }}</p>
            <p><strong>Direcci&oacute;n:</strong> {{ $empresa->direccion }}</p>
        </div>

        <div>
            <h3>Contacto</h3>
            <p><strong>Tel&eacute;fono:</strong> {{ $empresa->telefono }}</p>
            <p><strong>E-mail:</strong> {{ $empresa->email }}</p>
        </div>
    </div>
</div>

@endsection

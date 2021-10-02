@extends('responsables.dashboard')

@section('page-content')

<a href="{{ route('new_empresas.index') }}" class="btn btn-outline-danger my-3">Volver</a>

<h2 class="text-center my-3">Rechazar Empresa</h2>

<div class="row mt-5">
    <div class="col-md-7">
        <p><strong class="text-uppercase">Nombre de la Empresa: </strong>{{$empresa->nombre_empresa}}</p>
        <p><strong class="text-uppercase">RUC: </strong>{{$empresa->ruc}}</p>
        <p><strong class="text-uppercase">&Aacute;rea: </strong>{{$empresa->facultad->nombre}}</p>
        <p><strong class="text-uppercase">Descripci&oacute;n: </strong></p>
        <div class="descripcion">
            {!! $empresa->descripcion !!}
        </div>
    </div>

    <div class="col-md-5">
        <form action="{{ route('new_empresas.destroy', ['empresa' => $empresa->id_empresa]) }}"
            method="POST"
        >
        @csrf
        @method('DELETE')

        <div class="form-group">
            <label for="cometario">Raz&oacute;n de rechazo</label>
            <textarea name="comentario" id="comentario" rows="5" class="form-control" style="resize: none;"></textarea>
        </div>

        <input type="submit" value="Rechazar" class="btn btn-danger">

        </form>
    </div>
</div>



@endsection

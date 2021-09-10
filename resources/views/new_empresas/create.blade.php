@extends('layouts.guest')

@section('guest-content')

<h2 class="my-5 text-center">¿Su empresa es nueva? Reg&iacute;strese con Nostros</h2>

<form class="row" action="{{ route('new_empresas.store') }}" method="POST">
    @csrf

    <fieldset class="col-md-4">
        <legend>Informaci&oacute;n de la Persona que registra la Empresa</legend>
        <div class="form-group">
            <label for="cedula">C&eacute;dula</label>
            <input type="text" class="form-control" id="cedula" name="cedula">
        </div>

        <div class="form-group">
            <label for="apellido-p">Apellido Paterno</label>
            <input type="text" class="form-control" id="apellido-p" name="apellido-p">
        </div>

        <div class="form-group">
            <label for="apellido-m">Apellido Materno</label>
            <input type="text" class="form-control" id="apellido-m" name="apellido-m">
        </div>

        <div class="form-group">
            <label for="nombres">Nombres</label>
            <input type="text" class="form-control" id="nombres" name="nombres">
        </div>

        <div class="form-group">
            <label for="titulo">Cargo en la Empresa</label>
            <input type="text" class="form-control" id="titulo" name="titulo">
        </div>

        <div class="form-group">
            <label for="genero">G&eacute;nero</label>
            <select name="genero" id="genero" class="form-control">
                <option selected disabled>-- seleccione --</option>
                <option value="M">MASCULINO</option>
                <option value="F">FEMENINO</option>
            </select>
        </div>
    </fieldset>

    <fieldset class="col-md-6 offset-md-2">
        <legend>Información de la Empresa</legend>

        <div class="form-group">
            <label for="ruc">RUC</label>
            <input type="text" class="form-control" id="ruc" name="ruc">
        </div>

        <div class="form-group">
            <label for="nombre_empresa">Nombre de la Empresa</label>
            <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa">
        </div>

        <div id="provincias-cantones-parroquias-selects"
        >
        </div>

        <div class="form-group">
            <label for="email">Email de contacto</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>

        <div class="form-group">
            <label for="email">Email de contacto</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>

    </fieldset>
</form>

@endsection

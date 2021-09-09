@extends('layouts.guest')

@section('guest-content')

<h2 class="my-5 text-center">¿Su empresa es nueva? Reg&iacute;strese con Nostros</h2>

<form class="row">
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
            <input type="text" class="form-control" id="genero" name="genero">
        </div>
    </fieldset>

    <fieldset class="col-md-6 offset-md-2">
        <legend>Información de la Empresa</legend>

        <div class="form-group">
            <label for="ruc">RUC</label>
            <input type="text" class="form-control" id="ruc" name="ruc">
        </div>
    </fieldset>
</form>

@endsection

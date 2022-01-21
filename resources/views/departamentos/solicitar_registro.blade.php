@extends('login.base')

@section('login_form')

    @if (session('status'))
        <div id="notificacion" data-mensaje="{{ session('status') }}"  data-clase="bg-success"></div>
    @endif

    <h2 class="text-center my-5">Correo Departamental</h2>

    <div class="row">
        <div class="col-md-5">
            <p style="font-size: 18px">
                Los departamentos internos de la Universidad que quieran hacer uso del Portal Empleo UTM
                para publicar ofertas de Prácticas Pre Profesionales, deberan tener habilitado un correo departamental
                bajo dominio de la UTM (<i>departamento@utm.edu.ec</i>).

                <br />
                <br />

                Ingrese el correo departamental para que le llegue un link de confirmacion donde se registrará el nombre
                del departamento a registrar.

                <br />
                <br />

                No se aceptaran correos personales, Ej: <i>carlos.perez@utm.edu.ec</i>
            </p>
        </div>

        <div class="col-md-5 mx-auto">
            <form class="mb-5" action="{{ route('departamento.solicitar_registro_post') }}" method="POST">
                @csrf

                <div class="form-header text-center">
                    <img src="{{ asset('/img/sga-64.png') }}" alt="sga logo">
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" />
                </div>

                <div class="form-group mt-4">
                    <input type="submit" value="Enviar" class="text-uppercase btn btn-block btn-primary" />
                </div>
            </form>

            @if ($errors->any())
                <div class="mt-5 alert alert-danger">
                    Hay errores al ingresar.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

@endsection

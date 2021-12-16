@extends('empresas.dashboard')

@section('page-content')

    <div class="row justify-content-between mt-3 mt-md-0 py-md-3">
        <div class="col-1">
            <a href="{{ route('empleos.show_estudiantes_empleos', ['empleo' => $empleo->id]) }}"
                class="btn btn-secondary">Volver</a>
        </div>

        <div class="col-4 d-md-flex juestify-content-between">
            <form class="d-flex mb-3 mb-md-0"
                action="{{ route('estudiantes_empleos.accept', ['estudiante_empleo' => $estudiante_empleo]) }}" method="POST"
            >
                @csrf
                <input type="submit" value="Candidato" class="btn btn-primary">
            </form>

            <div class="formulario-eliminar ml-auto"
                data-ruta="{{ route('estudiantes_empleos.reject', ['estudiante_empleo' => $estudiante_empleo]) }}"
                data-csrf="{{ csrf_token() }}"
            ></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h2 class="text-center my-2">Datos del aspirante</h2>

            <p><strong class="text-uppercase">Nombre completo: </strong>{{ $estudiante_empleo->personal->nombres_completos }}</p>
            <p><strong class="text-uppercase">C&eacute;dula: </strong>{{ $datos_aspirante->cedula }}</p>
            <p><strong class="text-uppercase">Tel&eacute;fono: </strong>{{ $datos_aspirante->telefono }}</p>

            <p><strong class="text-uppercase">E-mail constitucional: </strong>{{ $datos_aspirante->email_utm }}</p>
            <p><strong class="text-uppercase">E-mail personal: </strong>{{ $datos_aspirante->email_alt }}</p>
            <p><strong class="text-uppercase">Ubicaci&oacute;n actual: </strong>
                {{ $datos_aspirante->provincia }} -
                {{ $datos_aspirante->canton }}
            </p>
        </div>

        <div class="col-md-6">
            @if ($estudiante_empleo->perfil)
                <p><strong class="text-uppercase">CV: </strong>{{ $estudiante_empleo->perfil->cv_link }}</p>
                <p><strong class="text-uppercase">Sobre {{ $estudiante_empleo->personal->nombres_completos }}: </strong></p>

                <div>
                    {!! $estudiante_empleo->perfil->description !!}
                </div>
            @endif
        </div>
    </div>

@endsection

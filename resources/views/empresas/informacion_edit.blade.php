@extends('empresas.dashboard')

@section('external-css')

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css"
    integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
/>

@endsection


@section('page-content')

@if (session('status'))
    <div id="notificacion" data-mensaje="{{ session('status') }}"  data-clase="bg-success"></div>
@endif

<a href="{{ route('empresas.informacion') }}" class="btn btn-outline-danger my-3">Volver</a>

<h2 class="text-center my-3">Actualizar Informaci&oacute;n</h2>

<form action="{{ route('empresas.informacion_update') }}"
    method="POST"
    class="row"
>
    @csrf
    @method('PUT')

    <fieldset class="col-md-4">
        <legend>Informaci&oacute;n de la Persona que representa Recursos Humanos de la Empresa</legend>
        <div class="form-group">
            <label for="cedula">C&eacute;dula</label>
            <input type="text" disabled class="form-control @error('cedula') is-invalid @enderror" id="cedula" name="cedula"
                @if (old('cedula'))
                    value="{{ old('cedula') }}"
                @else
                    value="{{ $representante->cedula }}"
                @endif
            />

            @error('cedula')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="apellido-p">Apellido Paterno</label>
            <input type="text" class="form-control @error('apellido_p') is-invalid @enderror text-uppercase" id="apellido-p"
                name="apellido_p"
                @if (old('apellido_p'))
                    value="{{ old('apellido_p') }}"
                @else
                    value="{{ $representante->apellido1 }}"
                @endif
            />
            @error('apellido_p')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="apellido-m">Apellido Materno</label>
            <input type="text" class="form-control @error('apellido_m') is-invalid @enderror text-uppercase" id="apellido-m"
                name="apellido_m"

                @if (old('apellido_m'))
                    value="{{ old('apellido_m') }}"
                @else
                    value="{{ $representante->apellido2 }}"
                @endif
            />
            @error('apellido_m')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="nombres">Nombres</label>
            <input type="text" class="form-control @error('nombres') is-invalid @enderror text-uppercase" id="nombres"
                name="nombres"

                @if (old('nombres'))
                    value="{{ old('nombres') }}"
                @else
                    value="{{ $representante->nombres }}"
                @endif
            />
            @error('nombres')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="titulo">Cargo en la Empresa</label>
            <input type="text" class="form-control @error('titulo') is-invalid @enderror text-uppercase" id="titulo" name="titulo"
                @if (old('titulo'))
                    value="{{ old('titulo') }}"
                @else
                    value="{{ $representante->titulo }}"
                @endif
            />
            @error('titulo')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="genero">G&eacute;nero</label>
            <select name="genero" id="genero" class="form-control @error('genero') is-invalid @enderror">
                <option selected disabled>-- seleccione --</option>
                <option value="M"
                    @if (old('genero'))
                        @if (old('genero') == 'M')
                            selected
                        @endif
                    @else
                        @if ($representante->genero == 'M')
                            selected
                        @endif
                    @endif
                >MASCULINO</option>

                <option value="F"
                    @if (old('genero'))
                        @if (old('genero') == 'F')
                        selected
                    @endif
                    @else
                        @if ($representante->genero == 'F')
                            selected
                        @endif
                    @endif
                >FEMENINO</option>
            </select>
            @error('genero')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>
    </fieldset>

    <fieldset class="col-md-6 offset-md-2">
        <legend>Información de la Empresa</legend>

        <div class="form-group">
            <label for="ruc">RUC</label>

            <input type="text" disabled class="form-control @error('ruc') is-invalid @enderror text-uppercase" id="ruc" name="ruc"
                @if (old('ruc'))
                    value="{{ old('ruc') }}"
                @else
                    value="{{ $empresa_informacion->ruc }}"
                @endif
            />

            @error('ruc')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="nombre_empresa">Nombre de la Empresa</label>

            <input type="text" disabled class="form-control @error('nombre_empresa') is-invalid @enderror text-uppercase"
                id="nombre_empresa" name="nombre_empresa"
                @if (old('nombre_empresa'))
                    value="{{ old('nombre_empresa') }}"
                @else
                    value="{{ $empresa_informacion->nombre_empresa }}"
                @endif
            />

            @error('nombre_empresa')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        {{-- <div
            id="provincias-cantones-parroquias-selects"

            @if (old('provincia'))
                data-provincia-value="{{ old('provincia') }}"
            @else
                data-provincia-value="{{ $empresa_informacion->id_provincia }}"
            @endif
            @error('provincia')
                data-provincia-error="{{ $message }}"
            @enderror

            @if (old('canton'))
                data-canton-value="{{ old('canton') }}"
            @else
                data-canton-value="{{ $empresa_informacion->id_canton }}"
            @endif
            @error('canton')
                data-canton-error="{{ $message }}"
            @enderror

            @if (old('parroquia'))
                data-parroquia-value="{{ old('parroquia') }}"
            @else
                data-parroquia-value="{{ $empresa_informacion->id_parroquia }}"
            @endif
            @error('parroquia')
                data-parroquia-error="{{ $message }}"
            @enderror
        ></div> --}}

        <div class="form-group">
            <label for="direccion">Direcci&oacute;n</label>
            <input type="text" class="form-control @error('direccion') is-invalid @enderror text-uppercase" id="direccion"
                name="direccion"
                @if (old('direccion'))
                    value="{{ old('direccion') }}"
                @else
                    value="{{ $empresa_informacion->direccion }}"
                @endif
            />
            @error('direccion')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email de contacto</label>
            <input type="email" disabled class="form-control @error('email') is-invalid @enderror text-lowercase" id="email" name="email"
                @if (old('email'))
                    value="{{ old('email') }}"
                @else
                    value="{{ $empresa_informacion->email }}"
                @endif
            />

            @error('email')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="telefono">Tel&eacute;fono de contacto</label>
            <input type="text" class="form-control @error('telefono') is-invalid @enderror text-uppercase" id="telefono"
                name="telefono"
                @if (old('telefono'))
                    value="{{ old('telefono') }}"
                @else
                    value="{{ $empresa_informacion->telefono }}"
                @endif
            />

            @error('telefono')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="descripcion">Descripci&oacute;n</label>

            <input
                type="hidden"
                id="descripcion"
                name="descripcion"
                @if (old('descripcion'))
                    value="{{ old('descripcion') }}"
                @else
                    value="{{ $empresa_informacion->descripcion }}"
                @endif
            />

            <trix-editor input="descripcion"
                class="form-control  @error ('descripcion') is-invalid @enderror"
                style="min-height: 300px; overflow-y: scroll"
            ></trix-editor>

            @error('descripcion')
                <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group d-flex justify-content-end mt-5">
            <input type="submit" value="Enviar" class="btn btn-block btn-primary">
        </div>
    </fieldset>
</form>

@endsection

@section('external-js')

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"
    integrity="sha512-/1nVu72YEESEbcmhE/EvjH/RxTg62EKvYWLG3NdeZibTCuEtW5M4z3aypcvsoZw03FAopi94y04GhuqRU9p+CQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
></script>

@endsection

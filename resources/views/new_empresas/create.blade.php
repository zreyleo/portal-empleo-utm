@extends('layouts.guest')

@section('external-css')

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css"
    integrity="sha512-5m1IeUDKtuFGvfgz32VVD0Jd/ySGX7xdLxhqemTmThxHdgqlgPdupWoSN8ThtUSLpAGBvA8DY2oO7jJCrGdxoA=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
/>

@endsection

@section('guest-content')

    <h2 class="my-5 text-center">¿Su empresa es nueva? Reg&iacute;strese con Nosotros</h2>

    <form class="row" action="{{ route('new_empresas.store') }}" method="POST">
        @csrf

        <fieldset class="col-md-4">
            <legend>Informaci&oacute;n de la Persona que registra la Empresa</legend>

            <div class="alert alert-info">
                <p style="font-size: 20px" class="text-justify">La persona que registra la empresa es una que dirige los
                    recursos humanos de la misma, esta persona también se considera que es la que va a supervisar
                    a los estudiantes que reservan en sus ofertas de prácticas.
                </p>
            </div>

            <div class="form-group">
                <label for="cedula">C&eacute;dula</label>
                <input type="text" class="form-control @error('cedula') is-invalid @enderror" id="cedula" name="cedula"
                    value="{{ old('cedula') }}">
                @error('cedula')
                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="apellido-p">Apellido Paterno</label>
                <input type="text" class="form-control @error('apellido_p') is-invalid @enderror text-uppercase" id="apellido-p"
                    name="apellido_p" value="{{ old('apellido_p') }}">
                @error('apellido_p')
                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="apellido-m">Apellido Materno</label>
                <input type="text" class="form-control @error('apellido_m') is-invalid @enderror text-uppercase" id="apellido-m"
                    name="apellido_m" value="{{ old('apellido_m') }}">
                @error('apellido_m')
                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nombres">Nombres</label>
                <input type="text" class="form-control @error('nombres') is-invalid @enderror text-uppercase" id="nombres"
                    name="nombres" value="{{ old('nombres') }}">
                @error('nombres')
                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="titulo">Cargo en la Empresa</label>
                <input type="text" class="form-control @error('titulo') is-invalid @enderror text-uppercase" id="titulo" name="titulo"
                    value="{{ old('titulo') }}">
                @error('titulo')
                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="genero">G&eacute;nero</label>
                <select name="genero" id="genero" class="form-control @error('genero') is-invalid @enderror">
                    <option selected disabled>-- seleccione --</option>
                    <option value="M" @if (old('genero') == 'M') selected @endif>MASCULINO</option>
                    <option value="F" @if (old('genero') == 'F') selected @endif>FEMENINO</option>
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
                <input type="text" class="form-control @error('ruc') is-invalid @enderror text-uppercase" id="ruc" name="ruc"
                    value="{{ old('ruc') }}">
                @error('ruc')
                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="nombre_empresa">Nombre de la Empresa</label>
                <input type="text" class="form-control @error('nombre_empresa') is-invalid @enderror text-uppercase"
                    id="nombre_empresa" name="nombre_empresa" value="{{ old('nombre_empresa') }}">
                @error('nombre_empresa')
                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                @enderror
            </div>

            {{-- <div
                id="provincias-cantones-parroquias-selects"

                @if (old('provincia')) data-provincia-value="{{ old('provincia') }}" @endif
                @error('provincia')
                    data-provincia-error="{{ $message }}"
                @enderror

                @if (old('canton')) data-canton-value="{{ old('canton') }}" @endif
                @error('canton')
                    data-canton-error="{{ $message }}"
                @enderror

                @if (old('parroquia')) data-parroquia-value="{{ old('parroquia') }}" @endif
                @error('parroquia')
                    data-parroquia-error="{{ $message }}"
                @enderror
            ></div> --}}

            <div
                id="provincias-cantones-parroquias-selects2"

                data-ruta="{{ route('ubicacion.provincias') }}"

                @if (old('provincia')) data-provincia-value="{{ old('provincia') }}" @endif
                @error('provincia')
                    data-provincia-error="{{ $message }}"
                @enderror

                @if (old('canton')) data-canton-value="{{ old('canton') }}" @endif
                @error('canton')
                    data-canton-error="{{ $message }}"
                @enderror

                @if (old('parroquia')) data-parroquia-value="{{ old('parroquia') }}" @endif
                @error('parroquia')
                    data-parroquia-error="{{ $message }}"
                @enderror
            ></div>

            <div class="form-group">
                <label for="direccion">Direcci&oacute;n</label>
                <input type="text" class="form-control @error('direccion') is-invalid @enderror text-uppercase" id="direccion"
                    name="direccion" value="{{ old('direccion') }}">
                @error('direccion')
                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email de contacto</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror text-lowercase" id="email" name="email"
                    value="{{ old('email') }}">
                @error('email')
                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="telefono">Tel&eacute;fono de contacto</label>
                <input type="text" class="form-control @error('telefono') is-invalid @enderror text-uppercase" id="telefono"
                    name="telefono" value="{{ old('telefono') }}">
                @error('telefono')
                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion">Descripci&oacute;n</label>

                {{-- <textarea type="text" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion"
                    name="descripcion" cols="4" style="resize: none">{{old('descripcion')}}</textarea> --}}

                <input
                    type="hidden"
                    id="descripcion"
                    name="descripcion"
                    value="{{ old('descripcion') }}"
                />

                <trix-editor input="descripcion"
                    class="form-control  @error ('descripcion') is-invalid @enderror"
                    style="min-height: 300px; overflow-y: scroll"
                ></trix-editor>

                @error('descripcion')
                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="area">Área</label>
                <select name="area" id="area" class="form-control @error('area') is-invalid @enderror">
                    <option value="" selected disabled>-- seleccione --</option>
                    @foreach ($areas as $area)
                        <option value="{{ $area->idfacultad }}"
                            @if (old('area') == $area->idfacultad) selected @endif
                        >{{ $area->nombre }}</option>
                    @endforeach
                </select>
                @error('area')
                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tipo">Tipo</label>
                <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror">
                    <option value="inaceptable" selected disabled>-- seleccione --</option>
                    <option value=1 @if (old('tipo') == 1) selected @endif>P&Uacute;BLICA</option>
                    <option value=0 @if (old('tipo') === 0) selected @endif>PRIVADA</option>
                </select>
                @error('tipo')
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


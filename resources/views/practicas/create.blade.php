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

<a href="{{ route('practicas.index') }}" class="btn btn-secondary my-3">Volver</a>

<h2 class="my-3 text-center">Crear una Oferta de Pr&aacute;ctica</h2>

<form action="{{ route('practicas.store') }}" method="POST" novalidate
    class="bg-white p-3 row mb-3"
>
    <div class="col-md-5">
        @csrf

        <div class="form-group">
            <label for="titulo">T&iacute;tulo (Ej: Estudiantes de Ingeniería Civil para estudio topográfico)</label>
            <input
                type="text"
                class="form-control @error ('titulo') is-invalid @enderror"
                name="titulo"
                value="{{ old('titulo') }}"
            >

            @error('titulo')
                <span
                    class="invalid-feedback d-block" role="alert"
                >{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="area">Área de Desenvolvimiento</label>
            <select
                class="form-control @error ('area') is-invalid @enderror"
                id="area"
                name="area"
            >
                <option value="" selected disabled>-- seleccione --</option>

                @foreach ($facultades as $facultad)
                    <option value="{{ $facultad->idfacultad }}"
                        {{ old('area') == $facultad->idfacultad ? 'selected' : '' }}
                    >{{ $facultad->nombre }}</option>
                @endforeach
            </select>

            @error('area')
                <span
                    class="invalid-feedback d-block" role="alert"
                >{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="cupo">Cupo para aceptar estudiantes</label>
            <input
                type="number"
                class="form-control @error ('cupo') is-invalid @enderror"
                name="cupo"
                min="1"
                step="1"
                value="{{ old('cupo') ? old('cupo') : 1 }}"
            >

            @error('cupo')
                <span
                    class="invalid-feedback d-block" role="alert"
                >{{ $message }}</span>
            @enderror
        </div>
    </div>


    <div class="col-md-7">
        <div class="form-group">
            <label for="requerimienos">Descripción de la Actividad</label>

            <input
                type="hidden"
                id="requerimientos"
                name="requerimientos"
                value="{{ old('requerimientos') }}"
            />

            <trix-editor input="requerimientos"
                class="@error ('titulo') is-invalid @enderror requerimientos"
            ></trix-editor>

            @error('requerimientos')
                <span
                    class="invalid-feedback d-block" role="alert"
                >{{ $message }}</span>
            @enderror
        </div>

    </div>

    <button type="submit" class="btn btn-primary ml-auto">Crear Oferta</button>
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

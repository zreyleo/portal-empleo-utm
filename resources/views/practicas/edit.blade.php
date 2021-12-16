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

<h2 class="my-3 text-center">Editar una Oferta de Práctica</h2>

<form action="{{ route('practicas.update', ['practica' => $practica->id]) }}" method="POST" novalidate
    class="bg-white p-3 row mb-3"
>
    <div class="col-md-5">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="titulo">T&iacute;tulo</label>
            <input
                type="text"
                class="form-control @error ('titulo') is-invalid @enderror"
                name="titulo"
                value="{{ $practica->titulo }}"
            >

            @error('titulo')
                <span
                    class="invalid-feedback d-block" role="alert"
                >{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="area">Área</label>
            <select
                class="form-control @error ('area') is-invalid @enderror"
                id="area"
                name="area"
            >
                <option value="" selected disabled>-- seleccione --</option>

                @foreach ($facultades as $facultad)
                    <option value="{{ $facultad->idfacultad }}"
                        {{ $practica->facultad_id == $facultad->idfacultad ? 'selected' : '' }}
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
                value="{{ $practica->cupo }}"
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
            <label for="requerimienos">Requerimientos</label>

            <input
                type="hidden"
                id="requerimientos"
                name="requerimientos"
                value="{{ $practica->requerimientos }}"
            />

            <trix-editor input="requerimientos"
                class="@error ('requerimientos') is-invalid @enderror requerimientos"
            ></trix-editor>

            @error('requerimientos')
                <span
                    class="invalid-feedback d-block" role="alert"
                >{{ $message }}</span>
            @enderror
        </div>

    </div>
    <button type="submit" class="btn btn-primary ml-auto">Guardar</button>
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

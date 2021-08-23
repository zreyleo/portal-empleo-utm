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

<h2 class="my-3 text-center">Crear una Oferta de Práctica</h2>

<div class="row mb-3">
    <div class="col-md-8 mx-auto">
        <form action="{{ route('practicas.store') }}" method="POST" novalidate>
            @csrf

            <div class="form-group">
                <label for="titulo">T&iacute;tulo</label>
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
                <label for="facultad_id">Área</label>
                <select
                    class="form-control @error ('facultad_id') is-invalid @enderror"
                    id="facultad_id"
                    name="facultad_id"
                >
                    <option value="" selected disabled>-- seleccione --</option>

                    @foreach ($facultades as $facultad)
                        <option value="{{ $facultad->idfacultad }}">{{ $facultad->nombre }}</option>
                    @endforeach
                </select>

                @error('facultad_id')
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


            <div class="form-group">
                <label for="requerimienos">Requerimientos</label>

                <input
                    type="hidden"
                    id="requerimientos"
                    name="requerimientos"
                    value="{{ old('requerimientos') }}"
                />

                <trix-editor input="requerimientos" class="@error ('titulo') is-invalid @enderror"></trix-editor>
                {{-- <textarea
                    class="form-control"
                    id="requerimientos"
                    rows="5"
                    style="resize: none"
                ></textarea> --}}

                @error('requerimientos')
                    <span
                        class="invalid-feedback d-block" role="alert"
                    >{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Crear Oferta</button>
        </form>

    </div>
</div>

@endsection

@section('external-js')

<script
    src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"
    integrity="sha512-/1nVu72YEESEbcmhE/EvjH/RxTg62EKvYWLG3NdeZibTCuEtW5M4z3aypcvsoZw03FAopi94y04GhuqRU9p+CQ=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
></script>

@endsection

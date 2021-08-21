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

<h2 class="my-3 text-center">Crear una Oferta de Empleo</h2>

<div class="row mb-3">
    <div class="col-md-8 mx-auto">
        <form action="{{ route('empleos.store') }}" method="POST" novalidate
            class="bg-white p-3"
        >
            @csrf

            <div class="form-group">
                <label for="titulo">Titulo de la oferta</label>
                <input
                    type="text"
                    class="form-control"
                    name="titulo"
                    value="{{ old('titulo') }}"
                >

                @error('titulo')
                    <span
                        class="invalid-feedback d-block" role="alert"
                    >{{ $message }}</span>
                @enderror
            </div>

            <div id="facultades-carreras-selects" data-carreras="{{ json_encode($carreras) }}">
            hola
            </div>

            <div class="form-group">
                <label for="requerimienos">Requerimientos</label>

                <input
                    type="hidden"
                    id="requerimientos"
                    name="requerimientos"
                    value="{{ old('requerimientos') }}"
                />

                <trix-editor input="requerimientos"></trix-editor>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Oferta</button>
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

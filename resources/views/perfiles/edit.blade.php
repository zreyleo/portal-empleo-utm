@extends('estudiantes.dashboard')

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

<a href="{{ route('perfil.show') }}" class="btn btn-outline-danger my-3">volver</a>

<h2 class="my-3 text-center">Formulario para actualizar su perfil</h2>

<div class="row mb-3">
    <div class="col-md-8 mx-auto">
        <form action="{{ route('perfil.update') }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="titulo">Link de descarga de Hoja de Vida</label>
                <input
                    type="text"
                    class="form-control @error ('titulo') is-invalid @enderror"
                    name="cv"
                    value="{{ $perfil->cv_link }}"
                >

                @error('cv')
                    <span
                        class="invalid-feedback d-block" role="alert"
                    >{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Acerca de usted:</label>

                <input
                    type="hidden"
                    id="description"
                    name="description"
                    value="{{ $perfil->description }}"
                />

                <trix-editor input="description"
                    class="form-control @error ('description') is-invalid @enderror requerimientos"
                ></trix-editor>

                @error('description')
                    <span
                        class="invalid-feedback d-block" role="alert"
                    >{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
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

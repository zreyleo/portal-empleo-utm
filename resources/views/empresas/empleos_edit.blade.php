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

<h2 class="my-3 text-center">Formulario para editar una oferta de empleo</h2>

<div class="row mb-3">
    <div class="col-md-8 mx-auto">
        <form action="{{ route('empleos.update', ['empleo' => $empleo->id]) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="titulo">Titulo de la oferta</label>
                <input
                    type="text"
                    class="form-control"
                    name="titulo"
                    value="{{ $empleo->titulo }}"
                >

                @error('titulo')
                    <span
                        class="invalid-feedback d-block" role="alert"
                    >{{ $message }}</span>
                @enderror
            </div>

            {{-- <div class="form-group">
                <label for="carrera">Carreras</label>
                <select
                    class="form-control"
                    id="carrera"
                    name="carrera"
                >
                    <option value="" selected disabled>-- seleccione --</option>

                    @foreach ($carreras as $carrera)
                        <option value="{{ $carrera->idescuela }}">{{ $carrera->nombre_carrera }}</option>
                    @endforeach
                </select>
            </div> --}}

            <div id="empleos-form-selects" data-carreras="{{ json_encode($carreras) }}" 
                data-carrera_id="{{ $empleo->carrera_id }}"
            ></div>

            <div class="form-group">
                <label for="requerimienos">Requerimientos</label>

                <input
                    type="hidden"
                    id="requerimientos"
                    name="requerimientos"
                    value="{{ $empleo->requerimientos }}"
                />

                <trix-editor input="requerimientos"></trix-editor>
                {{-- <textarea
                    class="form-control"
                    id="requerimientos"
                    rows="5"
                    style="resize: none"
                ></textarea> --}}
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

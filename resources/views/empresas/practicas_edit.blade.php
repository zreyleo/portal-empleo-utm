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

{{-- {{ $practica }} --}}

<h2 class="my-3 text-center">Formulario para editar una oferta de pr&aacute;ctica</h2>

<div class="row mb-3">
    <div class="col-md-8 mx-auto">
        <form action="{{ route('practicas.update', ['practica' => $practica->id]) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="titulo">Titulo de la oferta</label>
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
                <label for="area">Areas</label>
                <select
                    class="form-control @error ('area') is-invalid @enderror"
                    id="area"
                    name="area"
                >
                    <option value="" disabled>-- seleccione --</option>

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
                    value={{ $practica->cupo }}
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
                    value="{{ $practica->requerimientos }}"
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

            <button type="submit" class="btn btn-primary">Guardar Pr&aacute;ctica</button>
            <div id="check-activa" data-activa={{ $practica->activa }}></div>
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

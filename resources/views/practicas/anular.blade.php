@extends('empresas.dashboard')

@section('page-content')

<a href="{{ route('practicas.index') }}" class="btn btn-primary my-3">Volver</a>

<h2 class="text-center my-3">Anular Oferta de Pr&aacute;ctica Pre Profesional</h2>

<div class="row mt-5">
    <div class="col-md-6">
        <p><strong class="text-uppercase">T&iacute;tulo: </strong>{{$practica->titulo}}</p>
        <p><strong class="text-uppercase">&Aacute;rea: </strong>{{$practica->facultad->nombre}}</p>
        <p><strong class="text-uppercase">Requerimientos: </strong></p>
        <div class="descripcion">
            {!! $practica->requerimientos !!}
        </div>
        <pre>
            {{ var_dump($practica) }}
        </pre>
    </div>

    <div class="col-md-6">
        <div class="alert alert-info" role="alert">
            <p>Una vez que se anule esta oferta de pr&aacute;ctica los estudiantes que participan en ella ya no realizar&aacute;n actividades en su instituci&oacute;n.</p>
            <p>Esta acci&oacute;n no se puede deshacer.</p>
        </div>

        <div id="formulario-anular-con-detalle"
            data-ruta="{{ route('practicas.destroy', ['practica' => $practica->id]) }}"
            data-csrf="{{ csrf_token() }}"
        ></div>

        {{-- <form action="{{ route('practicas.destroy', ['practica' => $practica->id]) }}"
            method="POST"
            onsubmit="
                if (!confirm('Desea Rechazar Esta empresa?, Esto no se puede deshacer.')) {
                    event.preventDefault();
                    return;
                }
            "
        >
            @csrf
            @method('DELETE')

            <div class="form-group">
                <label for="cometario">Raz&oacute;n de rechazo</label>
                <textarea
                    name="detalle"
                    id="comentario"
                    rows="5"
                    class="form-control @error ('comentario') is-invalid @enderror"
                    style="resize: none;"
                    required
                ></textarea>

                @error('comentario')
                    <span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <input type="submit" value="Rechazar" class="btn btn-danger">

        </form> --}}

        <table class="table mt-3">
            <thead>
                <tr>
                    <th><strong>Participantes</strong></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($practica->estudiantes_practicas as $estudiante)
                    <tr>
                        <td>
                            {{ $estudiante->personal->nombres_completos }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>No hay Participantes</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>



@endsection

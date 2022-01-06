@extends('empresas.dashboard')

@section('page-content')

<a href="{{ route('practicas.index') }}" class="btn btn-secondary my-3">Volver</a>

<h2 class="text-center my-3">Anular Oferta de Pr&aacute;ctica Pre Profesional</h2>

<div class="row mt-5">
    <div class="col-md-6">
        <p><strong class="text-uppercase">T&iacute;tulo: </strong>{{$practica->titulo}}</p>

        <p><strong class="text-uppercase">&Aacute;rea: </strong>{{$practica->facultad->nombre}}</p>

        <p><strong class="text-uppercase">Requerimientos: </strong></p>
        <div class="descripcion">
            {!! $practica->requerimientos !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="alert alert-info" role="alert">
            <p>Una vez que se anule esta oferta de pr&aacute;ctica los estudiantes que participan en ella ya no realizar&aacute;n actividades en su instituci&oacute;n.</p>
            <p>Esta acci&oacute;n no se puede deshacer.</p>
        </div>

        <div id="formulario-anular-con-detalle"
            data-ruta="{{ route('practicas.destroy', ['practica' => $practica->id]) }}"
            data-ruta-exito="{{ route('practicas.index') }}"
            data-csrf="{{ csrf_token() }}"
        ></div>

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

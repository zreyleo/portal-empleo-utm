@extends('empresas.dashboard')

@section('page-content')

    <h2 class="my-3">Carreras que Ofrece La Universidad T&eacute;cnica de Manab&iacute;</h2>

    <p class="my-3 w-75">Usted puede publicar ofertas de empleo y pr&aacute;cticas
        hacia todas las carreras que se estudian en la Universidad T&eacute;cnica de Manab&iacute;, entre ellas
        est&aacute;n:</p>

    {{-- <ul class="lista-carreras">
    @foreach ($facultades as $facultad)
        <li style="font-size: 12px; background-color: white;">
            <p style="font-weight: bold; text-decoration: underline">{{ $facultad->nombre }}</p>
            @php
                $escuelas_filtradas = $facultad->escuelas->filter(function ($escuela, $key) {
                    return ($escuela->titulo_academico_m != '' && $escuela->nomenclatura != '');
                })
            @endphp
            <ul>
                @foreach ($escuelas_filtradas as $escuela)
                    <li>{{ $escuela->nombre }}</li>
                @endforeach
            </ul>
        </li>
    @endforeach

</ul> --}}

    <ul class="lista-carreras">
        <li style="font-size: 12px;">
            <p style="font-weight: bold; text-decoration: underline">CIENCIAS DE LA SALUD </p>
            <ul>
                <li>MEDICINA</li>
                <li>ENFERMERIA</li>
                <li>BIOQUIMICA Y FARMACIA</li>
            </ul>
        </li>
        <li style="font-size: 12px;">
            <p style="font-weight: bold; text-decoration: underline">CIENCIAS HUMANISTICAS Y SOCIALES </p>
            <ul>
                <li>SECRETARIADO EJECUTIVO</li>
                <li>TRABAJO SOCIAL</li>
                <li>DERECHO</li>
            </ul>
        </li>
        <li style="font-size: 12px;">
            <p style="font-weight: bold; text-decoration: underline">CIENCIAS VETERINARIAS </p>
            <ul>
                <li>MEDICINA VETERINARIA</li>
                <li>ACUICULTURA Y PESQUERIA (BAHIA)</li>
                <li>RECURSOS NATURALES RENOVABLES</li>
            </ul>
        </li>
        <li style="font-size: 12px;">
            <p style="font-weight: bold; text-decoration: underline">INGENIERÍA AGRONÓMICA </p>
            <ul>
                <li>INGENIERIA AGRONOMICA (LODANA)</li>
                <li>INGENIERIA AMBIENTAL</li>
            </ul>
        </li>
        <li style="font-size: 12px;">
            <p style="font-weight: bold; text-decoration: underline">CIENCIAS MATEMÁTICAS FÍSICAS Y QUÍMICAS </p>
            <ul>
                <li>INGENIERIA INDUSTRIAL</li>
                <li>INGENIERIA ELECTRICA</li>
                <li>INGENIERIA CIVIL</li>
                <li>INGENIERIA MECANICA</li>
                <li>INGENIERIA QUIMICA</li>
                <li>BIOTECNOLOGÍA</li>
                <li>ALIMENTOS</li>
                <li>ELECTRÓNICA Y AUTOMATIZACIÓN</li>
                <li>ARQUITECTURA</li>
            </ul>
        </li>
        <li style="font-size: 12px;">
            <p style="font-weight: bold; text-decoration: underline">CIENCIAS INFORMÁTICAS </p>
            <ul>
                <li>ANALISTA DE SISTEMAS</li>
                <li>TELECOMUNICACIONES</li>
                <li>INGENIERIA DE SISTEMAS INFORMATICOS</li>
                <li>TECNOLOGIAS DE LA INFORMACION</li>
                <li>INGENIERIA DE SOFTWARE</li>
            </ul>
        </li>
        <li style="font-size: 12px;">
            <p style="font-weight: bold; text-decoration: underline">FILOSOFÍA LETRAS Y CIENCIAS DE LA EDUCACIÓN </p>
            <ul>
                <li>EDUCACION ARTISTICA</li>
                <li>CONTABILIDAD COMPUTARIZADA</li>
                <li>IDIOMAS Y LINGUISTICA MENCION INGLES IDIOMA ELECTIVO Y ESPAÑOL</li>
                <li>CASTELLANO Y LITERATURA</li>
                <li>PSICOLOGIA EDUCATIVA Y ORIENTACION VOCACIONAL</li>
                <li>FISICA Y MATEMATICAS</li>
                <li>EDUCACION FISICA, DEPORTES Y RECREACION</li>
                <li>QUIMICA Y BIOLOGIA</li>
                <li>EDUCACION BASICA</li>
            </ul>
        </li>
        <li style="font-size: 12px;">
            <p style="font-weight: bold; text-decoration: underline">CIENCIAS ZOOTÉCNICAS </p>
            <ul>
                <li>INGENIERIA ZOOTECNICA (CHONE)</li>
                <li>INGENIERIA EN INDUSTRIAS AGROPECUARIAS (CHONE)</li>
            </ul>
        </li>
        <li style="font-size: 12px; background-color: #FFFFFF77;">
            <p style="font-weight: bold; text-decoration: underline ">CIENCIAS ADMINISTRATIVAS Y ECONÓMICAS </p>
            <ul>
                <li>ECONOMIA</li>
                <li>TURISMO</li>
                <li>GASTRONOMIA</li>
                <li>ADMINISTRACION DE EMPRESAS</li>
                <li>CONTABILIDAD Y AUDITORIA</li>
            </ul>
        </li>

    </ul>

@endsection

<style>

    html {
        font-size: 62.5%;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 1.6rem;
        margin: 0;
    }

    .text-center {
        text-align: center;
    }

    th, td {
        font-size: 1rem;
        border: 1px solid black;
        margin: 0;
        padding: 4px
    }

</style>

<h2 style="text-align: center;">Postulaciones de empleo de los estudiantes de la FACULTAD DE {{ $facultad->nombre }}</h2>

{{-- <p>Desde {{ $fecha_inicio->format('Y/m/d') }} hasta {{ $fecha_fin->format('Y/m/d') }}</p> --}}

<table cellpadding="pixels" cellspacing="pixels">
    <thead>
        <tr>
            <th>Estudiante</th>
            <th>Carrera</th>
            <th>Empresa</th>
            <th>Titulo del Empleo</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($escuelas as $escuela)

            @foreach ($escuela->empleos as $empleo)

                <tr>
                    <td colspan="5" style="text-align: center">{{ $escuela->nombre }}</td>
                </tr>

                @forelse ($empleo->estudiantes_empleos as $estudiante_empleo)

                    <tr>
                        <td>{{ $estudiante_empleo->personal->nombres_completos }}</td>
                        <td>{{ $escuela->nombre }}</td>
                        <td>{{ $empleo->empresa->nombre_empresa }}</td>
                        <td>{{ $empleo->titulo }}</td>
                        <td>{{ $estudiante_empleo->created_at->format('Y/m/d') }}</td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="5">No postulaciones de empleo de la CARRERA {{ $escuela->nombre }}</td>
                    </tr>

                @endforelse

            @endforeach

        @endforeach

    </tbody>
</table>

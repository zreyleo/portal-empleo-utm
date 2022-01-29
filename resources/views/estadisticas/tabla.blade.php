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

<h2 style="text-align: center;">Reservaciones de PPP de los estudiantes de la FACULTAD DE {{ $facultad->nombre }}</h2>

<p>Desde {{ $fecha_inicio->format('Y/m/d') }} hasta {{ $fecha_fin->format('Y/m/d') }}</p>

<table cellpadding="pixels" cellspacing="pixels">
    <thead>
        <tr>
            <th>Estudiante</th>
            <th>Carrera</th>
            <th>Empresa</th>
            <th>Titulo de la Práctica</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($practicas as $practica)

            @foreach ($practica->estudiantes_practicas as $estudiante_practica)

                <tr>
                    <td>{{ $estudiante_practica->personal->nombres_completos }}</td>
                    <td>{{ $estudiante_practica->pasantia->escuela->nombre }}</td>
                    <td>{{ $practica->empresa->nombre_empresa }}</td>
                    <td>{{ $practica->titulo }}</td>
                    <td>{{ $estudiante_practica->created_at->format('Y/m/d') }}</td>
                </tr>

            @endforeach

        @empty

            <tr>
                <td colspan="5">Los estudiantes no han reservado ninguna práctica</td>
            </tr>

        @endforelse
    </tbody>
</table>

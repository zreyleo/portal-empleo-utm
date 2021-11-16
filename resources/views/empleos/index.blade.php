@extends('empresas.dashboard')

@section('page-content')

    <h2 class="my-5 text-center">Tus Ofertas de Empleo</h2>

    @if (session('status'))
        <div id="notificacion" data-mensaje="{{ session('status') }}"  data-clase="bg-success"></div>
    @endif

    <button
        onclick="
            const hola = Swal.fire(
                                    'Good job!',
                                    'You clicked the button!',
                                    'success'
                                    );
                                    console.log(hola);
                                    return;
        "
    >hola</button>

    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Aspirantes</th>
                    <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($empleos as $empleo)

                    <tr>
                        <td scope="row">{{ $empleo->id }}</td>
                        <td>{{ $empleo->titulo }}</td>
                        {{-- <td>{{ $empleo->aspirantes->count() }}</td> --}}
                        <td>&nbsp;</td>
                        <td class="d-flex">
                            <a href="{{ route('empleos.show', ['empleo' => $empleo->id]) }}"
                                class="btn btn-success">Ver</a>

                            <a href="{{ route('empleos.edit', ['empleo' => $empleo->id]) }}"
                                class="btn btn-warning mx-2">Editar</a>

                            <a href="{{ route('empleos.show_estudiantes_empleos', ['empleo' => $empleo->id]) }}"
                                class="btn btn-info text-white mr-2">Ver Aspirantes</a>

                            <form action="{{ route('empleos.destroy', ['empleo' => $empleo->id]) }}" method="POST"
                                onsubmit="

                                    const hola = Swal.fire({
                                    title: 'Do you want to save the changes?',
                                    showDenyButton: true,
                                    showCancelButton: true,
                                    confirmButtonText: 'Save',
                                    denyButtonText: `Don't save`,
                                    }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        Swal.fire('Saved!', '', 'success')
                                    } else if (result.isDenied) {
                                        Swal.fire('Changes are not saved', '', 'info')
                                        event.preventDefault();
                                    }
                                    });
                                    console.log(hola);
                                    return;
                            ">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Eliminar" class="btn btn-danger">
                            </form>
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="4">No ofertas de empleo creadas</td>
                    </tr>

                @endforelse
            </tbody>
        </table>

    </div>

@endsection

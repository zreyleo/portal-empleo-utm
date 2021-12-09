@extends('login.base')

@section('login_form')

    <h2 class="text-center my-5">Login de Estudiantes</h2>

    <div class="row">
        <div class="col-md-4 mx-auto">
            <form action="{{ route('login.choose_carrera_post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="carrera">Carrera</label>

                    <select name="carrera" id="carrera" class="form-control">
                        <option disabled selected>-- seleccione --</option>

                        @foreach ($carreras as $carrera)

                            <option value="{{ $carrera->idescuela }}|{{ $carrera->idmalla }}">{{ $carrera->escuela }}</option>

                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-4">
                    <input type="submit" value="Ingresar" class="btn btn-block btn-primary" />
                </div>
            </form>

            @if ($errors->any())
                <div class="alert alert-danger">
                    Hay errores al ingresar.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

@endsection

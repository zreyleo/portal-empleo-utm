@extends('login.base')

@section('login_form')

    <h2 class="text-center my-5">Login de Docentes</h2>

    <div class="row">
        <div class="col-md-4 mx-auto">
            <form action="{{ route('login.responsables_post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">E-mail Institucional</label>
                    <input type="email" name="email" id="email" class="form-control" />
                </div>

                {{-- <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password"
                            class="form-control"
                        />
                    </div> --}}

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

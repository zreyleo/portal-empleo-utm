@extends('login.base')

@section('login_form')

    <h2 class="text-center my-5">Login de Empresas</h2>

    <div class="row">
        <div class="col-md-5 mx-auto">
            <form class="mb-5" action="{{ route('login.empresas_post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" />
                </div>

                {{-- <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password"
                            class="form-control"
                        />
                    </div> --}}

                <div class="form-group mt-4">
                    <input type="submit" value="Ingresar" class="text-uppercase btn btn-block btn-primary" />
                </div>
            </form>

            <a class="text-primary" href="{{ route('new_empresas.create') }}">&#191;Es nueva Empresa? Reg&iacute;strese</a>

            @if ($errors->any())
                <div class="mt-5 alert alert-danger">
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

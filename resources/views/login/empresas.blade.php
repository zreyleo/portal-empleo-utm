<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>UTM - Tesis</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

    <nav class="navbar navbar-light bg-primary text-white">
        <a class="navbar-brand" href="{{ route('landing') }}">Portal Empleo</a>

        <div>
            <a class="text-white" href="{{ route('login.empresas_get') }}">Login Empresas</a>
        </div>
    </nav>

    <div class="container">
        <h2 class="text-center my-5">Login de Empresas</h2>

        <div class="row">
            <div class="col-md-4 mx-auto">
                <form action="{{ route('login.empresas_post') }}" method="POST">
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
    </div>

</body>

</html>

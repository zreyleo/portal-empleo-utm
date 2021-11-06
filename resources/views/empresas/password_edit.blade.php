@extends('empresas.dashboard')

@section('page-content')

<h2 class="my-3 text-center">Cambiar Password</h2>

@if (session('status'))
    <div id="notificacion" data-mensaje="{{ session('status') }}"  data-clase="bg-success"></div>
@endif

<div class="row">
    <div class="col-md-5 mx-auto">
        <form class="mb-5" action="{{ route('empresas.password_update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="current_password">Password Actual</label>
                <input type="password" name="current_password" id="current_password" class="form-control" />
            </div>

            <div class="form-group">
                <label for="new_password">Nueva Password</label>
                <input type="password" name="new_password" id="new_password"
                    class="form-control"
                />
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmar Password</label>
                <input type="password" name="confirm_password" id="confirm_password"
                    class="form-control"
                />
            </div>

            <div class="form-group mt-4">
                <input type="submit" value="Actualizar Password" class="btn btn-block btn-primary" />
            </div>
        </form>

        @if ($errors->any())
            <div class="mt-5 alert alert-danger">
                Hay errores.
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


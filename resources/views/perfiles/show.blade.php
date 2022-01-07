@extends('estudiantes.dashboard')

@section('page-content')

<a href="{{ route('perfil.edit') }}" class="btn btn-warning my-3">Editar</a>
<h1 class="text-center">Tu Perfil</h1>


<div class="row">
    <div class="col-md-4">
        <label for="cv">Link de descarga de tu Hoja de Vida</label>
        <a href="{{ $perfil->cv_link }}">{{ $perfil->cv_link }}</a>

        <br>


    </div>
    <div class="col-md-8">
        <h2>Acerca de Usted:</h2>
        <div>
            {!! $perfil->description !!}
        </div>
    </div>
</div>



@endsection


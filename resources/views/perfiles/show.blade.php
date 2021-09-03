@extends('estudiantes.dashboard')

@section('page-content')

<a href="{{ route('perfil.edit') }}" class="btn btn-warning my-3">Editar</a>
<h1 class="text-center">Tu Perfil</h1>


<div class="row">
    <div class="col-md-3">
        <label for="cv">Link de tu CV</label>
        <a href="{{ $perfil->cv_link }}">{{ $perfil->cv_link }}</a>
    </div>
    <div class="col-md-9">
        <div>
            {!! $perfil->description !!}
        </div>
    </div>
</div>



@endsection


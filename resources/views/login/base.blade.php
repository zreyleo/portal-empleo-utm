@extends('layouts.guest')

@section('guest-content')

@yield('login_form')

@endsection

@section('external-js')

<script>

document.body.classList.add('body-form-sga')

</script>

@endsection


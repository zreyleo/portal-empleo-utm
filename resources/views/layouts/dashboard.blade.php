@extends('layouts.app')

@section('contenido')

<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>Portal Empleo</h3>
            <strong>PE</strong>
        </div>

        <ul class="list-unstyled components">

            @yield('enlaces')

        </ul>

    </nav>

    <!-- Page Content  -->
    <div id="content" class="content">
        <nav class="navbar navbar-expand-lg navbar-light header">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i>
                    <span>Men&uacute;</span>
                </button>

                <p class="mb-0">
                    @yield('user')
                </p>
                <a href="{{ route('logout') }}" class="btn btn-danger">Cerrar Sesi&oacute;n</a>
            </div>
        </nav>
        <div class="page-content">
            <div class="container">

                @yield('page-content')

            </div>
        </div>
        <footer class="footer">
            UTM - Dirección de TICS - Copyright © 2021.
        </footer>
    </div>
</div>

@endsection

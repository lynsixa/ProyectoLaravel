@extends('layouts.app')

@section('content')
<div class="wrapper d-flex">
    <aside class="p-4" style="background-color: #f8f9fa; min-height: 100vh;">
        <div class="text-center mb-4">
            <a href="{{ route('admin.index') }}">
                <img src="{{ asset('img/log.png') }}" alt="EMEN" style="width: 80px;">
            </a>
            <h1>EMEN</h1>
        </div>
        <nav>
            <ul class="menu list-unstyled">
                <li><a href="#" ><i class="bi bi-house-door-fill"></i> Inicio</a></li>
                <li><a href="{{ route('admin.eventos.index') }}"><i class="bi bi-list-ul"></i> Eventos</a></li>
                <li><a href="{{ route('admin.nis.index') }}"><i class="bi bi-tags"></i> NIS</a></li>
                <li><a href="{{ route('admin.usuario.index') }}"><i class="bi bi-person-fill"></i> Usuario</a></li>
                <li><a href="{{ route('admin.informes.index') }}" class="btn">Informe</a></li>
                <li><a href="{{ route('admin.producto.index') }}"><i class="bi bi-bag-plus"></i> Subir Producto</a></li> <!-- Enlace actualizado -->
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-danger w-100 mt-3" type="submit">
                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <footer class="mt-5 text-center">
            <p>© 2024 EMEN</p>
        </footer>
    </aside>

    <main class="flex-grow-1 p-4">
        <h2 class="mb-4">Bienvenido Administrador</h2>

        <div class="botones-container">
            <a href="{{ route('admin.calendario.index') }}" class="btn">Calendario</a>
            <a href="{{ route('admin.eventos.index') }}" class="btn">Eventos</a>
            <a href="{{ route('admin.nis.index') }}" class="btn">NIS</a>
            <a href="{{ route('admin.usuario.index') }}" class="btn">Usuarios</a>
            <a href="{{ route('admin.informes.index') }}" class="btn">Informe</a>
            <a href="{{ route('admin.producto.index') }}" class="btn">Subir Producto</a> <!-- Enlace actualizado -->
        </div>

        <div class="logo-derecho">
            <img src="{{ asset('img/log.png') }}" alt="Logo grande EMEN" width="200">
        </div>
    </main>
</div>

{{-- Estilos locales (NO mover arriba, es mejor aquí para mantener orden en Blade) --}}
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endpush

<style>
    .btn {
        background-color: #FFD700;
        color: #111;
        padding: 12px 24px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: transform 0.3s ease, background-color 0.3s ease;
        margin: 10px;
        display: inline-block;
        text-align: center;
        text-decoration: none;
    }

    .btn:hover {
        background-color: #FFB600;
        transform: scale(1.05);
    }

    .botones-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 20px;
    }

    .logo-derecho {
        margin-top: 30px;
        text-align: center;
    }

    .logo-derecho img {
        width: 200px;
    }

    aside .menu li {
        margin-bottom: 15px;
    }

    aside .menu li a {
        text-decoration: none;
        color: #333;
        font-weight: bold;
    }

    aside .menu li a:hover {
        color: #FFD700;
    }
</style>
@endsection

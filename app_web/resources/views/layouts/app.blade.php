<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Aplicación')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')

</head>
<body>
    <header>
        <nav>
            <!-- Aquí puedes agregar tu barra de navegación -->
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <!-- Pie de página -->
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

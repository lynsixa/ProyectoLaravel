<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="{{ asset('css/styleRecupera.css') }}">
</head>
<body>
    <div class="form-container">
        <h2><i class="fas fa-unlock-alt"></i> Recuperar Contraseña</h2>

        {{-- Alertas de error o éxito --}}
        @if (session('mensaje'))
            <div class="alert success">
                {{ session('mensaje') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
        @endif

        {{-- Mostrar errores de validación --}}
        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('recuperar.enviar') }}" method="POST">
            @csrf
            <div class="input-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" name="email" id="email" placeholder="Correo electrónico" required>
            </div>
            <button type="submit">Enviar Enlace</button>
        </form>

        <div class="text-end p-3">
            <a href="{{ route('login') }}" class="btn btn-custom">
                <i class="bi bi-arrow-left-circle"></i> Volver
            </a>
        </div>
    </div>
</body>
</html>

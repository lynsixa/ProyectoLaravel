<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EMEN</title>
    <link rel="icon" type="image/png" href="{{ asset('img/log.png') }}">

    <!-- Estilos -->
    <link rel="stylesheet" href="{{ asset('css/login-registro.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="form-container p-4 shadow rounded">
                    <div class="text-center mb-4">
                        <img src="{{ asset('img/log.png') }}" width="80" height="70" alt="Logo EMEN">
                        <h2 class="mt-2">Iniciar Sesión</h2>
                    </div>

                    {{-- Mensaje de éxito --}}
                    @if(session('mensaje'))
                        <div class="alert alert-success">
                            {{ session('mensaje') }}
                        </div>
                    @endif

                    {{-- Errores de validación --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Formulario --}}
                    <form action="{{ route('login.process') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="loginEmail" name="correo" placeholder="Ingrese su correo" required>
                        </div>

                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Ingrese su contraseña" required>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">
                                Ingresar
                            </button>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('recuperar.form') }}">¿Olvidaste tu contraseña?</a>
                            <a href="{{ route('registro.form') }}">Registrarse</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Validar Código</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/cssnis.css') }}" />
    <script>
        (function() {
            window.history.pushState(null, "", window.location.href);
            window.addEventListener("popstate", function() {
                window.history.pushState(null, "", window.location.href);
            });

            document.addEventListener("keydown", function(event) {
                if (event.key === "Backspace" || (event.altKey && event.key === "ArrowLeft")) {
                    event.preventDefault();
                    alert("No puedes retroceder en esta página.");
                }
            });
        })();
    </script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-white">Ingrese el Código</h1>

        @if(session('mensaje'))
            <div class="alert alert-warning">{{ session('mensaje') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="formu">
            <form action="{{ route('usuarios.codigonis.validar') }}" method="POST" class="mb-4">
                @csrf
                <input type="text" id="codigo" name="codigo" class="form-control mb-3" placeholder="Código" required />
                <input type="submit" value="Validar" class="btn btn-primary" />
            </form>
        </div>

        @if(session('numeroMesa') && session('numeroPiso'))
            <div class="alert alert-success">
                <strong>Mesa:</strong> {{ session('numeroMesa') }}<br />
                <strong>Piso:</strong> {{ session('numeroPiso') }}
            </div>
        @endif

        <div>
            <a href="{{ route('usuarios.codigonis.cerrar_sesion') }}" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        let currentIndex = 0;
        const images = ['1.jpg', '2.jpg', '3.jpg'];

        function changeBackground() {
            document.body.style.backgroundImage = `url(${images[currentIndex]})`;
            currentIndex = (currentIndex + 1) % images.length;
        }

        setInterval(changeBackground, 2000);
        changeBackground();
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detalles de la Mesa</title>
    <link rel="icon" href="{{ asset('img/log.png') }}" type="image/png" />
    <link rel="stylesheet" href="{{ asset('Css/CssUsuarioCrud.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        body {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            transition: background-image 1s ease-in-out;
            min-height: 100vh;
            margin: 0;
        }
    </style>

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
    <header class="bg-dark py-3 shadow-sm">
        <div class="container d-flex flex-wrap align-items-center justify-content-between">
            <a href="{{ url('/') }}" class="d-flex align-items-center text-white text-decoration-none">
                <img src="{{ asset('img/log.png') }}" alt="Logo" style="height: 50px;" />
            </a>
            <nav class="nav">
                <a class="nav-link text-white" href="{{ url('../Usuarioconcrud/gesProductos/perfil.php') }}">Perfil</a>
                <a class="nav-link text-white" href="{{ route('menu.index') }}">Menú</a>
                <a class="nav-link text-danger" href="{{ route('usuarios.codigonis.cerrar_sesion') }}">Cerrar sesión</a>
            </nav>
        </div>
    </header>

    <main id="main-content" class="container py-5">
        <section class="animate__animated animate__fadeIn">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-yellow">
                    <i class="bi bi-info-circle-fill me-2"></i>Detalles de la Mesa
                </h2>
            </div>

            <div class="card card-dark-yellow shadow-lg rounded-4 mx-auto" style="max-width: 600px;">
                <div class="card-body">
                    <ul class="list-group list-group-flush fs-5">
                        <li class="list-group-item">
                            <i class="bi bi-hash me-2"></i>
                            <strong>Número de Mesa:</strong> {{ $numeroMesa }}
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-building me-2"></i>
                            <strong>Número de Piso:</strong> {{ $numeroPiso }}
                        </li>
                        <li class="list-group-item">
                            <i class="bi bi-card-text me-2"></i>
                            <strong>Descripción del Menú:</strong> {{ $menuDescripcion }}
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    </main>

    <script>
        let currentIndex = 0;
        const images = [
            "{{ asset('Img/IMG_5081.JPG') }}",
            "{{ asset('Img/DSC06494.jpg') }}",
            "{{ asset('Img/IMG_5105.JPG') }}"
        ];

        function changeBackground() {
            document.body.style.backgroundImage = `url('${images[currentIndex]}')`;
            currentIndex = (currentIndex + 1) % images.length;
        }

        setInterval(changeBackground, 2000);
        changeBackground();
    </script>
</body>
</html>

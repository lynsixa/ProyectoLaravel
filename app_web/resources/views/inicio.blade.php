<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('img/log.png') }}" type="image/png">
    <title>DisruptivoClub</title>
    <link rel="stylesheet" href="{{ asset('css/StylePrincipal.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>

    <div class="fondo-rotativo">
        <img src="{{ asset('img/IMG_5081.JPG') }}" alt="Fondo 1">
        <img src="{{ asset('img/DSC06494.jpg') }}" alt="Fondo 2">
        <img src="{{ asset('img/IMG_5105.JPG') }}" alt="Fondo 3">
    </div>
    
    <header class="animate__animated animate__fadeInDown">
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('img/log.png') }}" alt="Logo">
            </a>
        </div>
        <div class="menu">
            <nav class="menu">
                <ul>
                    <li><a href="#contacto">Contáctenos</a></li>
                    <li><a href="{{ url('/login') }}">Iniciar Sesión</a></li>
                    <li><a href="{{ url('/registro') }}">Registro</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main id="main-content">
        <section class="bienvenida animate__animated animate__zoomIn">
            <h1>Disruptivo-Club</h1> <br>
            <video controls width="600" autoplay loop>
                <source src="{{ asset('img/Disruptivo.mp4') }}" type="video/mp4">
            </video>

            <section id="contacto">
                <div class="texto">
                    <h3>Carrera 14A # 83-13 | Primer piso</h3>
                    <h3>314 343 8087</h3>
                    <h3>314 343 8087</h3>
                </div>

                <div class="contenido-derecho">
                    <div class="mapa">
                        <iframe src="https://www.google.com/maps/embed?pb=..." width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                    <img src="{{ asset('img/ig.jpg') }}" alt="QR Código" class="responsive-image">
                </div>
            </section>
        </section>
    </main>

    <footer class="foter">
        <div class="tex">
            <p>&copy; 2024 Emen. Todos los derechos reservados.</p>
            <p>Para solicitar permisos, contacta a: <a href="mailto:emen@gmail.com">emen@gmail.com</a></p>
        </div>
    </footer>

    <script src="{{ asset('js/fondo.js') }}"></script>
</body>
</html>

<!-- resources/views/bartender/index.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Órdenes Bartender</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(to right, #1f1c2c, #928dab);
            color: white;
        }
        .card {
            border-radius: 15px;
        }
        .btn-custom {
            border-radius: 30px;
        }
        .card-body h5 {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .container {
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">📦 Solicitudes Pendientes (Bartender)</h2>
    <div class="row">
        @if ($solicitudes->isEmpty())
            <div class="col-12">
                <div class="alert alert-light text-dark text-center">No hay solicitudes pendientes</div>
            </div>
        @else
            @foreach ($solicitudes as $sol)
                <div class="col-md-4 mb-4">
                    <div class="card shadow bg-dark text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title">🧾 Solicitud #{{ $sol->idSolicitud }}</h5>
                            <p class="card-text">{{ nl2br(e($sol->Descripcion)) }}</p>

                            <!-- Formulario para marcar como despachada -->
                            <form method="POST" action="{{ route('Bartender.despachar') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $sol->idSolicitud }}">
                                <button class="btn btn-success btn-custom w-100 mt-2" type="submit">✅ Marcar como Listo</button>
                            </form>

                            <!-- Formulario para rechazar -->
                            <form method="POST" action="{{ route('Bartender.rechazar') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $sol->idSolicitud }}">
                                <input type="hidden" name="motivo" id="motivoTexto">
                                <button class="btn btn-danger btn-custom w-100 mt-2" type="button" onclick="mostrarRechazo({{ $sol->idSolicitud }})">❌ Rechazar</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<!-- Formulario oculto para enviar el motivo de rechazo -->
<form id="formRechazo" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="id" id="rechazoId">
    <input type="hidden" name="accion" value="rechazar">
    <input type="hidden" name="motivo" id="motivoTexto">
</form>

<!-- Sección para mostrar las órdenes despachadas y rechazadas -->
<div class="container mt-5">
    <h2 class="text-center mb-4">📦 Órdenes Despachadas y Rechazadas</h2>
    <div class="row">
        @foreach ($ordenesEntregadas as $sol)
            <div class="col-md-4 mb-4">
                <div class="card shadow bg-dark text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">🧾 Solicitud #{{ $sol->idSolicitud }}</h5>
                        <p class="card-text">{{ nl2br(e($sol->Descripcion)) }}</p>
                        <p><strong>Estado:</strong> 
                            @if($sol->Despachado == 1)
                                <span class="text-success">Despachada</span>
                            @elseif($sol->Despachado == -1)
                                <span class="text-danger">Rechazada</span>
                            @else
                                <span class="text-warning">Pendiente</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Botón para cerrar sesión -->
<div class="container mt-5 text-center">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-danger btn-custom w-100">Cerrar Sesión</button>
    </form>
</div>

<script>
function mostrarRechazo(id) {
    // Usamos SweetAlert para obtener el motivo del rechazo
    Swal.fire({
        title: 'Motivo del Rechazo',
        input: 'textarea',
        inputPlaceholder: 'Escribe el motivo del rechazo...',
        inputAttributes: {
            'aria-label': 'Motivo del rechazo'
        },
        showCancelButton: true,
        confirmButtonText: 'Rechazar',
        cancelButtonText: 'Cancelar',
        background: '#1f1c2c',
        color: 'white'
    }).then((result) => {
        if (result.isConfirmed && result.value.trim() !== "") {
            // Asignar el motivo al campo oculto
            document.getElementById("rechazoId").value = id;
            document.getElementById("motivoTexto").value = result.value.trim();
            // Enviar el formulario de rechazo
            document.querySelector("form[action='{{ route('Bartender.rechazar') }}']").submit();
        }
    });
}
</script>

</body>
</html>

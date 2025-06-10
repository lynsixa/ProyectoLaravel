<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Órdenes del Mesero 🍽️</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: #fdf6f0;
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .despachadas {
            margin-top: 40px;
        }
        /* Estilo para el cuadro de motivo de rechazo */
        #rechazoMotivo {
            display: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center text-dark mb-4">👨‍🍳 Órdenes listas para entregar</h1>

    <!-- Mensajes de error o éxito -->
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('rechazada'))
        <div class="alert alert-warning">{{ session('rechazada') }}</div>
    @endif
    @if(session('entregada'))
        <div class="alert alert-success">{{ session('entregada') }}</div>
    @endif

    <div class="row">
        @foreach($entregas as $entrega)
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h5 class="card-title">Orden ID: {{ $entrega->idEntrega }} 🍽️</h5>
                        <p class="card-text"><strong>Descripción de la Orden:</strong> {{ $entrega->Descripcion }}</p>
                        <p class="card-text"><strong>Descripción de la Solicitud:</strong> {{ $entrega->solicitud->Descripcion }}</p>
                        
                        <!-- Formulario para entregar la orden -->
                        <form method="POST" action="{{ route('mesero.entregar') }}">
                            @csrf
                            <input type="hidden" name="idEntrega" value="{{ $entrega->idEntrega }}">
                            <button type="submit" class="btn btn-success w-100">✅ Entregar</button>
                        </form>

                        <!-- Botón para mostrar el motivo de rechazo -->
                        <button type="button" class="btn btn-danger w-100 mt-2" onclick="confirmarRechazo({{ $entrega->idEntrega }})">❌ Rechazar</button>

                        <!-- Cuadro para llenar el motivo del rechazo -->
                        <form id="formRechazo{{ $entrega->idEntrega }}" method="POST" action="{{ route('mesero.rechazar') }}" style="display: none;" class="mt-3">
                            @csrf
                            <input type="hidden" name="idEntrega" value="{{ $entrega->idEntrega }}">
                            <textarea name="motivo" class="form-control" rows="3" placeholder="Escribe el motivo de rechazo..." required></textarea>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-warning">Rechazar Orden</button>
                                <button type="button" class="btn btn-secondary" onclick="cancelarRechazo({{ $entrega->idEntrega }})">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Órdenes Despachadas y Rechazadas -->
    <div class="despachadas mt-5">
        <h2>📦 Órdenes Despachadas y Rechazadas</h2>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entregadas_y_rechazadas as $entrega)
                    <tr>
                        <td>{{ $entrega->idEntrega }}</td>
                        <td>{{ $entrega->Descripcion }}</td>
                        <td>
                            @if($entrega->Entregado == 1)
                                ✅ Entregada
                            @elseif($entrega->Entregado == -1)
                                ❌ Rechazada
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Botón de cerrar sesión -->
   <!-- Botón de cerrar sesión -->
<div class="text-center mt-4">
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="btn btn-warning">Cerrar Sesión</button>
    </form>
</div>

</div>

<!-- Script para manejar el rechazo de una orden -->
<script>
function confirmarRechazo(id) {
    // Mostrar confirmación antes de rechazar
    Swal.fire({
        title: '¿Estás seguro de rechazar esta orden?',
        text: 'No podrás cambiar el estado después de rechazarla.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Rechazar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar el formulario para ingresar el motivo de rechazo si la confirmación es positiva
            document.getElementById('formRechazo' + id).style.display = 'block';
        }
    });
}

function cancelarRechazo(id) {
    // Ocultar el formulario de rechazo
    document.getElementById('formRechazo' + id).style.display = 'none';
}
</script>

</body>
</html>

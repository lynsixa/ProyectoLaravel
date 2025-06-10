@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Botón para volver a la página del gerente -->
    <a href="javascript:void(0);" onclick="redirectToGerenteIndex()" class="btn btn-dark mb-4">
        <i class="bi bi-arrow-left-circle"></i> Volver
    </a>

    <div class="card">
        <div class="card-body">
            <h2 class="mb-4 text-primary text-center">Calendario de Eventos</h2>

            <div id="calendar"></div>
        </div>
    </div>
</div>

<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.css" rel="stylesheet">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/locales/es.js"></script>

<script src="{{ asset('js/redirect.js') }}"></script> <!-- Aquí se incluye el script para la redirección -->

<style>
    #calendar {
        max-width: 900px;
        margin: 0 auto;
        min-height: 600px;
    }
</style>

<script>
    $(document).ready(function() {
        var calendar = new FullCalendar.Calendar($('#calendar')[0], {
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: function(info, successCallback, failureCallback) {
                // Llamamos a la ruta para obtener los eventos para el mes actual
                $.ajax({
                    url: "{{ route('gerente.calendario.eventos') }}",  <!-- Cambiado a la ruta gerente -->
                    dataType: 'json',
                    data: {
                        start: info.startStr, // Enviar la fecha de inicio
                        end: info.endStr,     // Enviar la fecha de fin
                    },
                    success: function(data) {
                        successCallback(data);  // Pasamos los datos de los eventos a FullCalendar
                    },
                    error: function() {
                        failureCallback("No se pudieron cargar los eventos");
                    }
                });
            },
            navLinks: true, // Permite navegar entre los días
            editable: true,  // Habilita la edición
            droppable: true, // Permite arrastrar los eventos si se configura
            selectable: true, // Permite seleccionar fechas
        });

        calendar.render();
    });
</script>

@endsection

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="{{ asset('css/login-registro.css') }}">


    <script>
        // Impide que el usuario navegue hacia atrás
        window.history.forward();
        function noBack() { window.history.forward(); }
        setTimeout("noBack()", 0);
        window.onload = noBack;
        window.onpageshow = function(evt) { if (evt.persisted) noBack(); };
        window.onunload = function() { void(0); };
        
    </script>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="form-container">
                    <center>
                    <img class="imagen" src="{{ asset('img/log.png') }}" width="80" height="70" alt="Logo">

                    </center>
                    <h1>Registrarme</h1>

                    <!-- Contenedor para mensajes de error -->
                    @if(session('mensaje'))
                        <div id="mensajeError" style="color: red; text-align: center;">
                            {{ session('mensaje') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div style="color: red; text-align: center;">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <!-- Formulario para registrar usuario -->
                    <form method="POST" action="{{ url('/registro') }}" id="registroForm">
                        @csrf

                        <div class="form-group">
                            <label for="nombre">Ingrese su Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese su Nombre" value="{{ old('nombre') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Ingrese su Apellido:</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Ingrese su Apellido" value="{{ old('apellido') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="documento">Número de Documento:</label>
                            <input type="text" class="form-control" id="documento" name="documento" placeholder="Número de Documento" value="{{ old('documento') }}" required>
                        </div>            
                        <div class="form-group">
                            <label for="correo">Ingrese su Correo:</label>
                            <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese su correo" value="{{ old('correo') }}" required>
                        </div>         
                        <div class="form-group">
                            <label for="fechadenacimiento">Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" id="fechadenacimiento" name="fechadenacimiento" value="{{ old('fechadenacimiento') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="userPassword">Contraseña:</label>
                            <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Ingrese su contraseña" required>
                        </div> 

                        <!-- Selección del tipo de documento -->
                        <div class="form-group">
                            <label for="tipoDocumento">Tipo de Documento:</label>
                            <select class="form-control" id="tipoDocumento" name="tipoDocumento" required>
                                <option value="">Seleccione...</option>
                                @foreach($tiposDocumento as $tipo)
                                    <option value="{{ $tipo->idTipodedocumento }}" {{ old('tipoDocumento') == $tipo->idTipodedocumento ? 'selected' : '' }}>
                                        {{ $tipo->Descripcion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Checkbox de términos y condiciones -->
                        <input name="acepto" type="checkbox" class="checkbox-terminos" required> 
                        <a href="{{ asset('pdf/terminosYcondiciones.pdf') }}" target="_blank" class="terminos">Términos y Condiciones</a>

                        <button type="submit" class="submit-button">
                            Registrarme
                        </button>
                        <a href="{{ url('/login') }}">¿Ya tienes cuenta?</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

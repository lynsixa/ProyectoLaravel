<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 30px;">
    <div style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px #ccc;">
        <h2 style="color: #2c3e50;">Hola {{ $usuario->Nombres }},</h2>
        <p>Hemos recibido una solicitud para restablecer tu contraseña.</p>
        <p>Haz clic en el siguiente enlace para continuar:</p>

        <p style="text-align: center; margin: 20px 0;">
            <a href="{{ $url }}" style="background-color: #3498db; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                Cambiar contraseña
            </a>
        </p>

        <p>Si no hiciste esta solicitud, puedes ignorar este correo.</p>

        <p style="color: #999;">Gracias,<br>El equipo de soporte</p>
    </div>
</body>
</html>

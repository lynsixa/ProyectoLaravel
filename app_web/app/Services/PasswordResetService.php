<?php

namespace App\Services;

use App\Interfaces\PasswordResetServiceInterface;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

/**
 * Class PasswordResetService
 *
 * Servicio que gestiona el flujo completo de recuperación de contraseña por correo electrónico:
 * generación de token, envío del correo, verificación del token y actualización de la contraseña.
 *
 * @package App\Services
 */
class PasswordResetService implements PasswordResetServiceInterface
{
    /**
     * Envía un correo al usuario con un enlace único para recuperar la contraseña.
     * 
     * @param Request $request La solicitud HTTP que contiene el email del usuario.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enviarCorreo(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $usuario = Usuario::where('Correo', $request->email)->first();

        if (!$usuario) {
            return back()->with('error', 'No se encontró un usuario con ese correo.');
        }

        DB::beginTransaction();
        try {
            // Marcar solicitud y generar token
            $usuario->password_request = 1;
            $usuario->token_password = Str::random(60);
            $usuario->save();
            DB::commit();

            // Construir URL de recuperación
            $url = url("/recuperar/cambiar/{$usuario->idUsuario}/{$usuario->token_password}");

            // Enviar correo
            Mail::send('emails.recuperacion', ['usuario' => $usuario, 'url' => $url], function ($message) use ($usuario) {
                $message->to($usuario->Correo)
                        ->subject('Recuperar contraseña')
                        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });

            return redirect()->route('login')->with('mensaje', 'Se ha enviado el enlace de recuperación a tu correo.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error en recuperación: " . $e->getMessage());
            return back()->with('error', 'No se pudo procesar la solicitud.');
        }
    }

    /**
     * Muestra el formulario de cambio de contraseña si el token y el usuario son válidos.
     *
     * @param int $id ID del usuario.
     * @param string $token Token de recuperación generado previamente.
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function mostrarFormularioCambio($id, $token)
    {
        $usuario = Usuario::where('idUsuario', $id)
                          ->where('token_password', $token)
                          ->where('password_request', 1)
                          ->first();

        if (!$usuario) {
            abort(404, 'Token inválido o expirado.');
        }

        return view('auth.cambiar_password', compact('id', 'token'));
    }

    /**
     * Actualiza la contraseña del usuario validando token y entrada.
     *
     * @param Request $request Solicitud HTTP que contiene la nueva contraseña, ID y token.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
            'id' => 'required',
            'token' => 'required',
        ]);

        $usuario = Usuario::where('idUsuario', $request->id)
                          ->where('token_password', $request->token)
                          ->where('password_request', 1)
                          ->first();

        if (!$usuario) {
            return back()->with('error', 'Token inválido o expirado.');
        }

        try {
            // Actualizar contraseña
            $usuario->Contraseña = bcrypt($request->password);
            $usuario->token_password = null;
            $usuario->password_request = 0;
            $usuario->save();

            Log::info("Contraseña actualizada para el usuario ID: {$usuario->idUsuario}");

            return redirect()->route('login')->with('mensaje', 'Contraseña actualizada correctamente.');
        } catch (\Exception $e) {
            Log::error("Error al actualizar contraseña: " . $e->getMessage());
            return back()->with('error', 'No se pudo actualizar la contraseña.');
        }
    }
}

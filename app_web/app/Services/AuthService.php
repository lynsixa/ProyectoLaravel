<?php

namespace App\Services;

use App\Interfaces\AuthServiceInterface;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthService
 *
 * Servicio que gestiona la autenticación de usuarios, incluyendo el inicio y cierre de sesión.
 * Aplica el principio de Responsabilidad Única (SRP) y la Inversión de Dependencias (DIP).
 *
 * @package App\Services
 */
class AuthService implements AuthServiceInterface
{
    /**
     * Maneja la lógica de autenticación del usuario.
     * Valida las credenciales, inicia sesión y redirige según el rol del usuario.
     *
     * @param Request $request Petición HTTP con las credenciales del usuario.
     * @return \Illuminate\Http\RedirectResponse Redirección a la vista correspondiente según el rol del usuario.
     */
    public function login(Request $request)
    {
        // Validación de entrada
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required|string',
        ]);

        // Buscar al usuario por su correo
        $usuario = Usuario::where('Correo', $request->correo)->first();

        // Verificar credenciales
        if ($usuario && Hash::check($request->password, $usuario->Contraseña)) {
            // Guardar información en sesión
            session([
                'idUsuario' => $usuario->idUsuario,
                'rol' => $usuario->Roles_idRoles,
            ]);

            // Redirigir según el rol
            return match ($usuario->Roles_idRoles) {
                1 => redirect()->route('admin.index'),
                2 => redirect()->route('gerente.index'),
                3 => redirect()->route('mesero.index'),
                4 => redirect()->route('usuarios.codigonis.index'),
                5 => redirect()->route('Bartender.index'),
                default => redirect()->route('home'),
            };
        }

        // Si las credenciales no coinciden
        return back()->withErrors(['correo' => 'Credenciales incorrectas'])->withInput();
    }

    /**
     * Cierra la sesión del usuario y limpia la información almacenada en sesión.
     *
     * @param Request $request Petición HTTP actual.
     * @return \Illuminate\Http\RedirectResponse Redirección al formulario de login.
     */
    public function logout(Request $request)
    {
        $request->session()->flush();

        return redirect()->route('login')->with('mensaje', 'Cerraste sesión exitosamente.');
    }
}

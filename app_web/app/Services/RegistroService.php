<?php

namespace App\Services;

use App\Interfaces\RegistroServiceInterface;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegistroService implements RegistroServiceInterface
{
    /**
     * Registra un nuevo usuario validando y almacenando sus datos.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registrarNuevoUsuario(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:45',
            'apellido' => 'required|string|max:45',
            'documento' => 'required|string|max:35',
            'correo' => 'required|email|max:100|unique:usuario,Correo',
            'fechadenacimiento' => 'required|date',
            'userPassword' => 'required|string|min:6',
            'tipoDocumento' => 'required|exists:tipo_de_documento,idTipodedocumento',
            'acepto' => 'accepted',
        ]);

        Usuario::create([
            'Nombres' => $request->nombre,
            'Apellidos' => $request->apellido,
            'Documento' => $request->documento,
            'Correo' => $request->correo,
            'Contraseña' => Hash::make($request->userPassword),
            'FechaDeNacimiento' => $request->fechadenacimiento,
            'token' => Str::random(40),
            'Tipo_de_documento_idTipodedocumento' => $request->tipoDocumento,
            'Roles_idRoles' => 4,
            'CodigoNis_idCodigoNis' => null,
        ]);

        return redirect()->route('login')->with('mensaje', 'Registro exitoso! Ahora puedes iniciar sesión.');
    }
}

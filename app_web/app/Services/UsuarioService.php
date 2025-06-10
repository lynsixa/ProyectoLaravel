<?php

namespace App\Services;

use App\Interfaces\UsuarioServiceInterface;
use App\Models\Usuario;
use App\Models\TipoDeDocumento;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @service UsuarioService
 * Servicio que encapsula la lógica de negocio para la gestión de usuarios.
 * 
 * Métodos:
 * - obtenerTodos(): Retorna todos los usuarios.
 * - obtenerTiposYRoles(): Retorna tipos de documento y roles disponibles.
 * - crearUsuario(Request $request): Valida y crea un nuevo usuario.
 * - obtenerUsuarioConRelacion(int $id): Obtiene un usuario por ID.
 * - actualizarUsuario(Request $request, int $id): Valida y actualiza un usuario existente.
 * - eliminarUsuario(int $id): Elimina un usuario por ID.
 */
class UsuarioService implements UsuarioServiceInterface
{
    public function obtenerTodos()
    {
        return Usuario::all();
    }

    public function obtenerTiposYRoles()
    {
        return [
            'tipos' => TipoDeDocumento::all(),
            'roles' => Rol::all(),
        ];
    }

    public function crearUsuario(Request $request)
    {
        $request->validate([
            'Nombres' => 'required|string|max:45',
            'Apellidos' => 'required|string|max:45',
            'Documento' => 'required|string|max:35|unique:usuario,Documento',
            'Correo' => 'required|string|email|max:100|unique:usuario,Correo',
            'Contraseña' => 'required|string|min:8|confirmed',
            'FechaDeNacimiento' => 'required|date',
            'Tipo_de_documento_idTipodedocumento' => 'required|exists:tipo_de_documento,idTipodedocumento',
            'Roles_idRoles' => 'required|exists:roles,idRoles',
        ]);

        Usuario::create([
            'Nombres' => $request->Nombres,
            'Apellidos' => $request->Apellidos,
            'Documento' => $request->Documento,
            'Correo' => $request->Correo,
            'Contraseña' => Hash::make($request->Contraseña),
            'FechaDeNacimiento' => $request->FechaDeNacimiento,
            'token' => Str::random(40),
            'Tipo_de_documento_idTipodedocumento' => $request->Tipo_de_documento_idTipodedocumento,
            'Roles_idRoles' => $request->Roles_idRoles,
        ]);
    }

    public function obtenerUsuarioConRelacion(int $id)
    {
        return Usuario::findOrFail($id);
    }

    public function actualizarUsuario(Request $request, int $id)
    {
        $request->validate([
            'Nombres' => 'required|string|max:45',
            'Apellidos' => 'required|string|max:45',
            'Documento' => 'required|string|max:35',
            'Correo' => 'required|string|email|max:100',
            'Contraseña' => 'nullable|string|min:8|confirmed',
            'FechaDeNacimiento' => 'required|date',
            'Tipo_de_documento_idTipodedocumento' => 'required|exists:tipo_de_documento,idTipodedocumento',
            'Roles_idRoles' => 'required|exists:roles,idRoles',
        ]);

        $usuario = Usuario::findOrFail($id);

        $data = $request->only([
            'Nombres', 'Apellidos', 'Documento', 'Correo',
            'FechaDeNacimiento', 'Tipo_de_documento_idTipodedocumento', 'Roles_idRoles'
        ]);

        if ($request->filled('Contraseña')) {
            $data['Contraseña'] = Hash::make($request->Contraseña);
        }

        $usuario->update($data);
    }

    public function eliminarUsuario(int $id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();
    }
}

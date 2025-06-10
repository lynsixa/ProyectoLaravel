<?php

namespace App\Services;

use App\Interfaces\RolServiceInterface;
use App\Models\Rol;
use Illuminate\Http\Request;

/**
 * @service RolService
 * Servicio que encapsula la lógica de negocio para los roles.
 * 
 * Métodos:
 * - obtenerTodos(): Retorna todos los roles.
 * - obtenerPorId(int $id): Retorna un rol por su ID.
 * - actualizar(Request $request, int $id): Valida y actualiza un rol.
 * - eliminar(int $id): Elimina un rol por su ID.
 */
class RolService implements RolServiceInterface
{
    public function obtenerTodos()
    {
        return Rol::all();
    }

    public function obtenerPorId(int $id)
    {
        return Rol::findOrFail($id);
    }

    public function actualizar(Request $request, int $id)
    {
        $request->validate([
            'Descripcion' => 'required|string|max:100|unique:roles,Descripcion,' . $id . ',idRoles',
        ]);

        $rol = Rol::findOrFail($id);
        $rol->update([
            'Descripcion' => $request->Descripcion,
        ]);
    }

    public function eliminar(int $id)
    {
        $rol = Rol::findOrFail($id);
        $rol->delete();
    }
}

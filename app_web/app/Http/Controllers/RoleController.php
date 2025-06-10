<?php

namespace App\Http\Controllers;

use App\Interfaces\RolServiceInterface;
use Illuminate\Http\Request;

/**
 * @controller RoleController
 * Controlador encargado de la gestión de roles.
 * 
 * Métodos:
 * - index(): Muestra todos los roles.
 * - edit(): Muestra el formulario de edición de un rol.
 * - update(): Valida y actualiza un rol existente.
 * - destroy(): Elimina un rol.
 */
class RoleController extends Controller
{
    protected RolServiceInterface $rolService;

    public function __construct(RolServiceInterface $rolService)
    {
        $this->rolService = $rolService;
    }

    public function index()
    {
        $roles = $this->rolService->obtenerTodos();
        return view('admin.roles.index', compact('roles'));
    }

    public function edit($id)
    {
        $rol = $this->rolService->obtenerPorId($id);
        return view('admin.roles.edit', compact('rol'));
    }

    public function update(Request $request, $id)
    {
        $this->rolService->actualizar($request, $id);
        return redirect()->route('admin.roles.index')->with('success', 'Rol actualizado exitosamente');
    }

    public function destroy($id)
    {
        $this->rolService->eliminar($id);
        return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado exitosamente');
    }
}

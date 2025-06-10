<?php

namespace App\Http\Controllers;

use App\Interfaces\UsuarioServiceInterface;
use Illuminate\Http\Request;

/**
 * @controller UsuarioController
 * Controlador responsable de manejar las solicitudes relacionadas con la gestión de usuarios.
 * 
 * Métodos:
 * - index(): Muestra todos los usuarios.
 * - create(): Muestra el formulario de creación de usuario.
 * - store(): Valida y almacena un nuevo usuario.
 * - edit(): Muestra el formulario de edición de usuario.
 * - update(): Valida y actualiza un usuario existente.
 * - destroy(): Elimina un usuario.
 */
class UsuarioController extends Controller
{
    protected UsuarioServiceInterface $usuarioService;

    public function __construct(UsuarioServiceInterface $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    public function index()
    {
        $usuarios = $this->usuarioService->obtenerTodos();
        return view('admin.usuario.index', compact('usuarios'));
    }

    public function create()
    {
        $data = $this->usuarioService->obtenerTiposYRoles();
        return view('admin.usuario.create', $data);
    }

    public function store(Request $request)
    {
        $this->usuarioService->crearUsuario($request);
        return redirect()->route('admin.usuario.index')->with('success', 'Usuario creado exitosamente');
    }

    public function edit($id)
    {
        $usuario = $this->usuarioService->obtenerUsuarioConRelacion($id);
        $data = $this->usuarioService->obtenerTiposYRoles();
        return view('admin.usuario.edit', array_merge(['usuario' => $usuario], $data));
    }

    public function update(Request $request, $id)
    {
        $this->usuarioService->actualizarUsuario($request, $id);
        return redirect()->route('admin.usuario.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy($id)
    {
        $this->usuarioService->eliminarUsuario($id);
        return redirect()->route('admin.usuario.index')->with('success', 'Usuario eliminado exitosamente');
    }
}
    
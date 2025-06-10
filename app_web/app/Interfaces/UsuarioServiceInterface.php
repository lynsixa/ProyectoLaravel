<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface UsuarioServiceInterface
{
    public function obtenerTodos();
    public function obtenerTiposYRoles();
    public function crearUsuario(Request $request);
    public function obtenerUsuarioConRelacion(int $id);
    public function actualizarUsuario(Request $request, int $id);
    public function eliminarUsuario(int $id);
}

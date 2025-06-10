<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

/**
 * @interface RolServiceInterface
 * Define los métodos para la lógica de negocio relacionada con roles.
 */
interface RolServiceInterface
{
    public function obtenerTodos();
    public function obtenerPorId(int $id);
    public function actualizar(Request $request, int $id);
    public function eliminar(int $id);
}

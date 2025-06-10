<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface ProductoServiceInterface
{
    public function obtenerTodosConCategoria();
    public function crearProductoYCategoria(Request $request);
    public function obtenerPorIdConCategoria(int $id);
    public function actualizarProductoYCategoria(Request $request, int $id);
    public function eliminarProductoYCategoria(int $id);
}

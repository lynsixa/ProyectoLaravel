<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface NISServiceInterface
{
    public function obtenerTodos();
    public function obtenerPorId(int $id);
    public function obtenerRecursosFormulario();
    public function crear(Request $request);
    public function actualizar(int $id, Request $request);
    public function eliminar(int $id);
}


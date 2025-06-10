<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface EventoServiceInterface
{
    public function obtenerTodos();
    public function crear(array $data);
    public function obtenerPorId(int $id);
    public function actualizar(int $id, array $data);
    public function eliminar(int $id);
}

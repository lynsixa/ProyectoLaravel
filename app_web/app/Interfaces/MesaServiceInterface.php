<?php

namespace App\Interfaces;

interface MesaServiceInterface
{
    public function obtenerTodas();
    public function crear(array $data);
    public function obtenerPorId(int $id);
    public function actualizar(int $id, array $data);
    public function eliminar(int $id);
}

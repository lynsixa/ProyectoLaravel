<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface SolicitudServiceInterface
{
    public function obtenerSolicitudesPendientes();
    public function obtenerSolicitudesProcesadas();
    public function despachar(int $id);
    public function rechazar(int $id, string $motivo);
}

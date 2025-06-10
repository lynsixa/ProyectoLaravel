<?php

namespace App\Services;

use App\Interfaces\SolicitudServiceInterface;
use App\Models\Solicitud;
use Illuminate\Support\Str;

class SolicitudService implements SolicitudServiceInterface
{
    public function obtenerSolicitudesPendientes()
    {
        return Solicitud::where('Despachado', 0)->get();
    }

    public function obtenerSolicitudesProcesadas()
    {
        return Solicitud::whereIn('Despachado', [1, -1])->get();
    }

    public function despachar(int $id)
    {
        $solicitud = Solicitud::findOrFail($id);
        $solicitud->update(['Despachado' => 1]);
    }

    public function rechazar(int $id, string $motivo)
    {
        $solicitud = Solicitud::findOrFail($id);
        $nuevoInforme = Str::finish($solicitud->Informe, "\nMotivo: {$motivo}");
        $solicitud->update([
            'Despachado' => -1,
            'Informe' => $nuevoInforme,
        ]);
    }
}

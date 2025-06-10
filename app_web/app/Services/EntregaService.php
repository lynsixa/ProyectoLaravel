<?php

namespace App\Services;

use App\Interfaces\EntregaServiceInterface;
use App\Models\Entrega;
use Illuminate\Support\Collection;

/**
 * @package App\Services
 * @implements EntregaServiceInterface
 * @author Tu Nombre
 * 
 * Servicio responsable de la lógica de negocio relacionada con las entregas.
 */
class EntregaService implements EntregaServiceInterface
{
    public function obtenerEntregasPendientes(): Collection
    {
        return Entrega::where('Entregado', 0)
            ->whereHas('solicitud', fn ($q) => $q->where('Despachado', 1))
            ->get();
    }

    public function obtenerEntregasFinalizadas(): Collection
    {
        return Entrega::whereIn('Entregado', [1, -1])->get();
    }

    public function entregar(int $id): void
    {
        $entrega = Entrega::findOrFail($id);
        $entrega->update(['Entregado' => 1]);
    }

    public function rechazar(int $id, string $motivo): void
    {
        $entrega = Entrega::findOrFail($id);

        if (in_array($entrega->Entregado, [1, -1])) {
            throw new \Exception('No se puede rechazar esta orden. Ya ha sido entregada o rechazada.');
        }

        $entrega->update([
            'Informe' => $motivo,
            'Entregado' => -1,
        ]);
    }
}

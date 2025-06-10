<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface EntregaServiceInterface
{
    /**
     * Obtener entregas pendientes.
     *
     * @return Collection
     */
    public function obtenerEntregasPendientes(): Collection;

    /**
     * Obtener entregas entregadas o rechazadas.
     *
     * @return Collection
     */
    public function obtenerEntregasFinalizadas(): Collection;

    /**
     * Marcar una entrega como entregada.
     *
     * @param int $id
     * @return void
     */
    public function entregar(int $id): void;

    /**
     * Rechazar una entrega.
     *
     * @param int $id
     * @param string $motivo
     * @return void
     */
    public function rechazar(int $id, string $motivo): void;
}

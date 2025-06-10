<?php

namespace App\Services;

use App\Interfaces\CalendarioServiceInterface;
use App\Models\Evento;

/**
 * Class CalendarioService
 *
 * Servicio encargado de obtener los eventos dentro de un rango de fechas.
 * Aplica el principio de responsabilidad única (SRP) al separar esta lógica de los controladores.
 *
 * @package App\Services
 */
class CalendarioService implements CalendarioServiceInterface
{
    /**
     * Obtiene los eventos que ocurren entre dos fechas.
     *
     * @param string $start Fecha de inicio en formato Y-m-d
     * @param string $end Fecha de fin en formato Y-m-d
     * @return array<int, array<string, mixed>> Lista de eventos formateados para FullCalendar
     */
    public function obtenerEventosEntreFechas(string $start, string $end): array
    {
        return Evento::whereBetween('Fecha_Evento', [$start, $end])
            ->select(
                'idEventos as id',
                'Titulo as title',
                'Fecha_Evento as start',
                'Descripcion as description'
            )
            ->get()
            ->toArray();
    }
}

<?php

namespace App\Services;

use App\Interfaces\EventoServiceInterface;
use App\Models\Evento;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class EventoService
 *
 * Servicio que encapsula la lógica de negocio relacionada con la gestión de eventos.
 * Aplica el principio de responsabilidad única (SRP) separando esta lógica del controlador.
 *
 * @package App\Services
 */
class EventoService implements EventoServiceInterface
{
    /**
     * Obtiene todos los eventos ordenados por fecha.
     *
     * @return Collection<int, Evento>
     */
    public function obtenerTodos(): Collection
    {
        return Evento::orderBy('Fecha_Evento', 'asc')->get();
    }

    /**
     * Crea un nuevo evento con los datos proporcionados.
     *
     * @param array<string, mixed> $data
     * @return Evento
     */
    public function crear(array $data): Evento
    {
        return Evento::create([
            'Titulo' => $data['titulo'],
            'Descripcion' => $data['descripcion'],
            'Fecha_Evento' => $data['fecha_evento'],
        ]);
    }

    /**
     * Obtiene un evento por su ID.
     *
     * @param int $id
     * @return Evento
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function obtenerPorId(int $id): Evento
    {
        return Evento::findOrFail($id);
    }

    /**
     * Actualiza un evento existente con los nuevos datos.
     *
     * @param int $id
     * @param array<string, mixed> $data
     * @return void
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function actualizar(int $id, array $data): void
    {
        $evento = Evento::findOrFail($id);
        $evento->update([
            'Titulo' => $data['titulo'],
            'Descripcion' => $data['descripcion'],
            'Fecha_Evento' => $data['fecha_evento'],
        ]);
    }

    /**
     * Elimina un evento por su ID.
     *
     * @param int $id
     * @return void
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function eliminar(int $id): void
    {
        $evento = Evento::findOrFail($id);
        $evento->delete();
    }
}

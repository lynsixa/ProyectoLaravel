<?php

namespace App\Services;

use App\Interfaces\MesaServiceInterface;
use App\Models\Mesa;

/**
 * Class MesaService
 *
 * Servicio encargado de la lógica de negocio para la gestión de mesas.
 * Implementa MesaServiceInterface para garantizar la inversión de dependencias.
 *
 * @package App\Services
 */
class MesaService implements MesaServiceInterface
{
    /**
     * Obtiene todas las mesas registradas.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Mesa[]
     */
    public function obtenerTodas()
    {
        return Mesa::all();
    }

    /**
     * Crea una nueva mesa con los datos proporcionados.
     *
     * @param array $data Datos de la mesa ['NumeroPiso', 'NumeroMesa']
     * @return Mesa
     */
    public function crear(array $data)
    {
        return Mesa::create([
            'NumeroPiso' => $data['NumeroPiso'],
            'NumeroMesa' => $data['NumeroMesa'],
        ]);
    }

    /**
     * Obtiene una mesa por su ID.
     *
     * @param int $id ID de la mesa
     * @return Mesa
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function obtenerPorId(int $id)
    {
        return Mesa::findOrFail($id);
    }

    /**
     * Actualiza los datos de una mesa existente.
     *
     * @param int $id ID de la mesa
     * @param array $data Datos actualizados ['NumeroPiso', 'NumeroMesa']
     * @return Mesa
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function actualizar(int $id, array $data)
    {
        $mesa = Mesa::findOrFail($id);
        $mesa->update([
            'NumeroPiso' => $data['NumeroPiso'],
            'NumeroMesa' => $data['NumeroMesa'],
        ]);
        return $mesa;
    }

    /**
     * Elimina una mesa por su ID.
     *
     * @param int $id ID de la mesa
     * @return void
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function eliminar(int $id)
    {
        $mesa = Mesa::findOrFail($id);
        $mesa->delete();
    }
}

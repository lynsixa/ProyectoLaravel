<?php

namespace App\Services;

use App\Interfaces\NISServiceInterface;
use App\Models\NIS;
use App\Models\Mesa;
use App\Models\Menu;
use App\Models\Evento;
use Illuminate\Http\Request;

/**
 * Servicio para gestionar lógica de negocio de NIS.
 *
 * @category Servicio
 * @package App\Services
 * @author Tú
 * @implements NISServiceInterface
 */
class NISService implements NISServiceInterface
{
    /**
     * Obtener todos los NIS.
     */
    public function obtenerTodos()
    {
        return NIS::all();
    }

    /**
     * Obtener un NIS por ID.
     */
    public function obtenerPorId(int $id)
    {
        return NIS::findOrFail($id);
    }

    /**
     * Obtener recursos relacionados para el formulario (mesas, menús, eventos).
     */
    public function obtenerRecursosFormulario()
    {
        return [
            'mesas' => Mesa::all(),
            'menus' => Menu::all(),
            'eventos' => Evento::all(),
        ];
    }

    /**
     * Crear un nuevo NIS después de validaciones.
     */
    public function crear(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:100',
            'numero_piso' => 'required|integer',
            'numero_mesa' => 'required|integer',
            'menu_id' => 'required|exists:menu,idMenu',
        ]);

        $existingNis = NIS::where('Descripcion', $request->descripcion)
            ->whereHas('Mesa', fn($q) => $q->where('NumeroPiso', $request->numero_piso)->where('NumeroMesa', $request->numero_mesa))
            ->first();

        if ($existingNis) {
            throw new \Exception('Ya existe un NIS con esa descripción y mesa.');
        }

        $mesa = Mesa::firstOrCreate(
            ['NumeroPiso' => $request->numero_piso, 'NumeroMesa' => $request->numero_mesa]
        );

        NIS::create([
            'Descripcion' => $request->descripcion,
            'Mesa_idMesa' => $mesa->idMesa,
            'Menu_idMenu' => $request->menu_id,
            'Eventos_idEventos' => $request->eventos_id,
            'Disponibilidad' => 1,
        ]);
    }

    /**
     * Actualizar un NIS existente.
     */
    public function actualizar(int $id, Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:100|unique:codigonis,Descripcion,' . $id . ',idCodigoNis',
            'numero_piso' => 'required|integer',
            'menu_id' => 'required|exists:menu,idMenu',
            'disponibilidad' => 'required|boolean',
        ]);

        $nis = NIS::findOrFail($id);

        $existingNis = NIS::where('Descripcion', $request->descripcion)
            ->where('Mesa_idMesa', $nis->Mesa_idMesa)
            ->where('idCodigoNis', '!=', $id)
            ->first();

        if ($existingNis) {
            throw new \Exception('Ya existe un NIS con esa descripción y mesa.');
        }

        $mesa = Mesa::where('NumeroPiso', $request->numero_piso)
            ->where('NumeroMesa', $nis->Mesa->NumeroMesa)
            ->firstOrFail();

        $nis->update([
            'Descripcion' => $request->descripcion,
            'Mesa_idMesa' => $mesa->idMesa,
            'Menu_idMenu' => $request->menu_id,
            'Eventos_idEventos' => $request->eventos_id,
            'Disponibilidad' => $request->disponibilidad,
        ]);
    }

    /**
     * Eliminar un NIS por ID.
     */
    public function eliminar(int $id)
    {
        $nis = NIS::findOrFail($id);
        $nis->delete();
    }
}

<?php

namespace App\Http\Controllers;

use App\Interfaces\EntregaServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @package App\Http\Controllers
 * @author Tu Nombre
 * 
 * Controlador responsable de la interacción del mesero con las entregas.
 */
class MeseroController extends Controller
{
    protected EntregaServiceInterface $entregaService;

    public function __construct(EntregaServiceInterface $entregaService)
    {
        $this->entregaService = $entregaService;
    }

    /**
     * Mostrar todas las entregas pendientes y finalizadas.
     */
    public function index()
    {
        $entregas = $this->entregaService->obtenerEntregasPendientes();
        $entregadas_y_rechazadas = $this->entregaService->obtenerEntregasFinalizadas();

        return view('mesero.index', compact('entregas', 'entregadas_y_rechazadas'));
    }

    /**
     * Marcar una entrega como completada.
     */
    public function entregar(Request $request)
    {
        $request->validate(['idEntrega' => 'required|integer']);

        $this->entregaService->entregar($request->idEntrega);

        return redirect()->route('mesero.index')->with('entregada', 'Orden entregada correctamente');
    }

    /**
     * Rechazar una entrega con un motivo.
     */
    public function rechazar(Request $request)
    {
        $request->validate([
            'idEntrega' => 'required|integer',
            'motivo' => 'required|string|max:250',
        ]);

        try {
            $this->entregaService->rechazar($request->idEntrega, $request->motivo);
        } catch (\Exception $e) {
            return redirect()->route('mesero.index')->with('error', $e->getMessage());
        }

        return redirect()->route('mesero.index')->with('rechazada', 'Orden rechazada correctamente');
    }
}

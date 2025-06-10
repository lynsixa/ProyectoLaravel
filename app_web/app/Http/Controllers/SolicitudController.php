<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\SolicitudServiceInterface;

/**
 * Controlador para la gestión de solicitudes por parte del bartender.
 * 
 * @package App\Http\Controllers
 */
class SolicitudController extends Controller
{
    protected SolicitudServiceInterface $solicitudService;

    public function __construct(SolicitudServiceInterface $solicitudService)
    {
        $this->solicitudService = $solicitudService;
    }

    /**
     * Muestra solicitudes pendientes y procesadas.
     */
    public function index()
    {
        $solicitudes = $this->solicitudService->obtenerSolicitudesPendientes();
        $ordenesEntregadas = $this->solicitudService->obtenerSolicitudesProcesadas();

        return view('bartender.index', compact('solicitudes', 'ordenesEntregadas'));
    }

    /**
     * Marca una solicitud como despachada.
     */
    public function despachar(Request $request)
    {
        $this->solicitudService->despachar($request->id);
        return redirect()->route('Bartender.index')->with('despachado', true);
    }

    /**
     * Marca una solicitud como rechazada con un motivo.
     */
    public function rechazar(Request $request)
    {
        $request->validate([
            'motivo' => 'required|string|max:500',
        ]);

        $this->solicitudService->rechazar($request->id, $request->motivo);
        return redirect()->route('Bartender.index')->with('rechazado', true);
    }
}

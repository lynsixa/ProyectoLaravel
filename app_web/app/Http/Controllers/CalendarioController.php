<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\CalendarioServiceInterface;

/**
 * Class CalendarioController
 *
 * Controlador encargado de manejar la lógica de visualización del calendario
 * y la consulta de eventos entre fechas específicas.
 *
 * @package App\Http\Controllers
 */
class CalendarioController extends Controller
{
    /**
     * Servicio para obtener eventos desde la lógica de negocio.
     *
     * @var CalendarioServiceInterface
     */
    protected CalendarioServiceInterface $calendarioService;

    /**
     * Constructor que inyecta el servicio de calendario.
     *
     * @param CalendarioServiceInterface $calendarioService
     */
    public function __construct(CalendarioServiceInterface $calendarioService)
    {
        $this->calendarioService = $calendarioService;
    }

    /**
     * Muestra la vista principal del calendario.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.calendario.index');
    }

    /**
     * Devuelve eventos que ocurren entre dos fechas específicas.
     *
     * Este método es consumido usualmente por FullCalendar o cualquier otra librería
     * de frontend para visualizar los eventos.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventos(Request $request)
    {
        $start = $request->get('start'); // Fecha de inicio del rango
        $end = $request->get('end');     // Fecha de fin del rango

        $eventos = $this->calendarioService->obtenerEventosEntreFechas($start, $end);

        return response()->json($eventos);
    }
}

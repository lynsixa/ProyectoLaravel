<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InformeAdminService;
use App\Services\InformeZipService;

/**
 * Controlador responsable de coordinar la generación y descarga de informes.
 */
class AdminInformeController extends Controller
{
    protected InformeAdminService $informeAdminService;
    protected InformeZipService $informeZipService;

    /**
     * Constructor con inyección de dependencias.
     *
     * @param InformeAdminService $informeAdminService
     * @param InformeZipService $informeZipService
     */
    public function __construct(
        InformeAdminService $informeAdminService,
        InformeZipService $informeZipService
    ) {
        $this->informeAdminService = $informeAdminService;
        $this->informeZipService = $informeZipService;
    }

    /**
     * Muestra la vista principal para la descarga de informes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.informes.index');
    }

    /**
     * Genera y descarga el informe de usuarios en formato Excel.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function generarInformeUsuarios()
    {
        return $this->informeAdminService->generarExcel();
    }

    /**
     * Genera ambos informes (usuarios y órdenes) y los empaqueta en un ZIP.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function generarTodosLosInformes()
    {
        return $this->informeZipService->generarZipConInformes();
    }
}

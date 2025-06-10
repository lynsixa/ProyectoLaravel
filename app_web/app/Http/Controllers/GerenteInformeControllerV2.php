<?php

namespace App\Http\Controllers;

use App\Interfaces\Informes\InformeUsuarioGerenteServiceInterface;
use App\Interfaces\Informes\InformeZipGerenteServiceInterface;

/**
 * Controlador responsable de coordinar la generación y descarga de informes
 * para el rol de gerente.
 *
 * @category Controller
 * @package App\Http\Controllers
 * @subpackage GerenteInformeControllerV2
 */
class GerenteInformeControllerV2 extends Controller
{
    protected InformeUsuarioGerenteServiceInterface $usuarioService;
    protected InformeZipGerenteServiceInterface $zipService;

    /**
     * Constructor con inyección de dependencias.
     *
     * @param InformeUsuarioGerenteServiceInterface $usuarioService
     * @param InformeZipGerenteServiceInterface $zipService
     */
    public function __construct(
        InformeUsuarioGerenteServiceInterface $usuarioService,
        InformeZipGerenteServiceInterface $zipService
    ) {
        $this->usuarioService = $usuarioService;
        $this->zipService = $zipService;
    }

    /**
     * Muestra la vista principal de informes.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('gerente.informes.index');
    }

    /**
     * Genera y descarga el informe de usuarios.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function generarInformeUsuarios()
    {
        return $this->usuarioService->generarExcel();
    }

    /**
     * Genera y descarga un archivo ZIP con todos los informes.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function generarTodosLosInformes()
    {
        return $this->zipService->generarZip();
    }
}

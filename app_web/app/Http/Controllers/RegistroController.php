<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoDeDocumento;
use App\Interfaces\RegistroServiceInterface;

/**
 * Controlador para el registro de nuevos usuarios.
 * Se encarga de mostrar el formulario y delegar el registro al servicio.
 *
 * @package App\Http\Controllers
 */
class RegistroController extends Controller
{
    protected RegistroServiceInterface $registroService;

    /**
     * Inyecta el servicio de registro.
     *
     * @param RegistroServiceInterface $registroService
     */
    public function __construct(RegistroServiceInterface $registroService)
    {
        $this->registroService = $registroService;
    }

    /**
     * Muestra el formulario de registro.
     *
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        $tiposDocumento = TipoDeDocumento::all();
        return view('registro', compact('tiposDocumento'));
    }

    /**
     * Procesa el registro de un nuevo usuario.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registrar(Request $request)
    {
        return $this->registroService->registrarNuevoUsuario($request);
    }
}

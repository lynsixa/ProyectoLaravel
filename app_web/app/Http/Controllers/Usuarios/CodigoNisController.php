<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Interfaces\CodigoNisServiceInterface;

/**
 * Controlador para gestionar la entrada de usuarios mediante códigos NIS.
 */
class CodigoNisController extends Controller
{
    protected CodigoNisServiceInterface $codigoNisService;

    /**
     * Inyecta el servicio y aplica middleware de autenticación.
     *
     * @param CodigoNisServiceInterface $codigoNisService
     */
    public function __construct(CodigoNisServiceInterface $codigoNisService)
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('idUsuario')) {
                return redirect()->route('login');
            }
            return $next($request);
        });

        $this->codigoNisService = $codigoNisService;
    }

    /**
     * Muestra el formulario para ingresar el código.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (Session::has('codigo')) {
            return redirect()->route('usuarios.codigonis.indexscan');
        }

        return view('usuarios.codigonis.index');
    }

    /**
     * Valida el código enviado por el usuario.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function validarCodigo(Request $request)
    {
        return $this->codigoNisService->validar($request);
    }

    /**
     * Muestra la pantalla principal luego de validar el código.
     *
     * @return \Illuminate\View\View
     */
    public function indexScan()
    {
        $numeroMesa = Session::get('numeroMesa', 'No disponible');
        $numeroPiso = Session::get('numeroPiso', 'No disponible');
        $menuDescripcion = Session::get('menuDescripcion', 'No disponible');

        return view('usuarios.codigonis.indexscan', compact('numeroMesa', 'numeroPiso', 'menuDescripcion'));
    }

    /**
     * Elimina los datos de sesión del usuario y redirige al login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cerrarSesion()
    {
        return $this->codigoNisService->cerrarSesion();
    }
}

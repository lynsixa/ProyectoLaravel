<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\AuthServiceInterface;

/**
 * Class LoginController
 *
 * Controlador responsable de manejar el inicio y cierre de sesión de los usuarios.
 * Este controlador delega la lógica de autenticación a un servicio que implementa
 * la interfaz AuthServiceInterface, siguiendo el principio de inversión de dependencias .
 *
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    /**
     * Servicio de autenticación.
     *
     * @var AuthServiceInterface
     */
    protected AuthServiceInterface $authService;

    /**
     * Inyección del servicio de autenticación.
     *
     * @param AuthServiceInterface $authService Servicio que maneja la lógica de login y logout.
     */
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Muestra el formulario de inicio de sesión.
     *
     * @return \Illuminate\View\View Vista del formulario de login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesa la solicitud de inicio de sesión del usuario.
     *
     * @param Request $request Solicitud HTTP con las credenciales del usuario.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View Redirección según rol o vista con error.
     */
    public function login(Request $request)
    {
        return $this->authService->login($request);
    }

    /**
     * Cierra la sesión del usuario.
     *
     * @param Request $request Solicitud HTTP con la sesión actual.
     * @return \Illuminate\Http\RedirectResponse Redirección a la pantalla de login.
     */
    public function logout(Request $request)
    {
        return $this->authService->logout($request);
    }
}

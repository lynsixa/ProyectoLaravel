<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\PasswordResetServiceInterface;

/**
 * Class RecuperarController
 *
 * Controlador encargado de manejar la recuperación de contraseñas.
 * Aplica el principio de Inversión de Dependencias mediante la inyección de la interfaz PasswordResetServiceInterface.
 *
 * @package App\Http\Controllers\Auth
 */
class RecuperarController extends Controller
{
    /**
     * Servicio para gestionar el proceso de recuperación de contraseña.
     *
     * @var PasswordResetServiceInterface
     */
    protected PasswordResetServiceInterface $passwordResetService;

    /**
     * RecuperarController constructor.
     *
     * @param PasswordResetServiceInterface $passwordResetService
     */
    public function __construct(PasswordResetServiceInterface $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    /**
     * Muestra el formulario para que el usuario ingrese su correo electrónico y reciba el enlace de recuperación.
     *
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        return view('auth.recupera');
    }

    /**
     * Envía un correo al usuario con un enlace para cambiar su contraseña.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enviarCorreo(Request $request)
    {
        return $this->passwordResetService->enviarCorreo($request);
    }

    /**
     * Muestra el formulario de cambio de contraseña desde el enlace recibido en el correo.
     *
     * @param int $id ID del usuario
     * @param string $token Token único de recuperación
     * @return \Illuminate\View\View|\Illuminate\Http\Response
     */
    public function cambiarForm($id, $token)
    {
        return $this->passwordResetService->mostrarFormularioCambio($id, $token);
    }

    /**
     * Guarda la nueva contraseña enviada por el usuario.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cambiarPassword(Request $request)
    {
        return $this->passwordResetService->cambiarPassword($request);
    }
}

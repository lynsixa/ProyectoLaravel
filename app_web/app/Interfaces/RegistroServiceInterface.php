<?php 

namespace App\Interfaces;

use Illuminate\Http\Request;

interface RegistroServiceInterface
{
    /**
     * Registra un nuevo usuario con los datos proporcionados.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registrarNuevoUsuario(Request $request);
}

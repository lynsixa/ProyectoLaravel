<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface PasswordResetServiceInterface
{
    public function enviarCorreo(Request $request);
    public function mostrarFormularioCambio($id, $token);
    public function cambiarPassword(Request $request);
}

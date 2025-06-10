<?php 

// app/Interfaces/CodigoNisServiceInterface.php
namespace App\Interfaces;

use Illuminate\Http\Request;

interface CodigoNisServiceInterface
{
    public function validar(Request $request);
    public function cerrarSesion();
}

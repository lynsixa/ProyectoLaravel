<?php

namespace App\Interfaces\Informes;

interface InformeUsuarioGerenteServiceInterface
{
    public function generarExcel(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}

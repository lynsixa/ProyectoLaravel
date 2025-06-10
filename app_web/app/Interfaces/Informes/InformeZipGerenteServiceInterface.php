<?php

namespace App\Interfaces\Informes;

interface InformeZipGerenteServiceInterface
{
    public function generarZip(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}

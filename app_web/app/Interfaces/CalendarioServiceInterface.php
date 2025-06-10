<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface CalendarioServiceInterface
{
    public function obtenerEventosEntreFechas(string $start, string $end): array;
}

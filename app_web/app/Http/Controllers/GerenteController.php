<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GerenteController extends Controller
{
    // Función que carga la vista principal del gerente
    public function index()
    {
        // Esta es la vista principal para el gerente
        return view('gerente.index');  // Asegúrate de que esta vista exista en resources/views/gerente/index.blade.php
    }

    // Puedes agregar más funciones según lo que necesites, como usuarios, informes, etc.
}

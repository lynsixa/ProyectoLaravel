<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Método index que retorna la vista 'inicio'
    public function index()
    {
        return view('inicio'); // Busca en resources/views/inicio.blade.php
    }
}

<?php

// app/Services/ProductoMenuService.php
namespace App\Services;

use App\Models\Producto;
use App\Interfaces\ProductoMenuServiceInterface;

class ProductoMenuService implements ProductoMenuServiceInterface
{
    public function obtenerDisponibles()
    {
        return Producto::with('categoria')
            ->where('Disponibilidad', 1)
            ->where('Cantidad', '>', 0)
            ->get();
    }
}

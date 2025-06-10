<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductoMenuServiceInterface;
use Illuminate\Http\Request;

/**
 * Controlador para mostrar el menú y gestionar el carrito de compras.
 *
 * @package App\Http\Controllers
 */
class MenuController extends Controller
{
    protected ProductoMenuServiceInterface $productoMenuService;

    public function __construct(ProductoMenuServiceInterface $productoMenuService)
    {
        $this->productoMenuService = $productoMenuService;
    }

    /**
     * Muestra los productos disponibles al cliente.
     *
     * @return \Illuminate\View\View
     */
   public function index()
{
    $productos = $this->productoMenuService->obtenerDisponibles();
    $carrito = collect(session('carrito', [])); // <- Recupera el carrito de la sesión

    return view('cliente.menu.index', compact('productos', 'carrito'));
}
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\ProductoServiceInterface;

/**
 * Controlador para gestionar productos y sus categorías.
 * Se encarga de recibir solicitudes HTTP y delegar la lógica al servicio correspondiente.
 *
 * @package App\Http\Controllers
 * @author TuNombre
 * @version 1.0
 */
class ProductoController extends Controller
{
    /**
     * @var ProductoServiceInterface Servicio para la lógica de productos
     */
    protected ProductoServiceInterface $productoService;

    /**
     * Inyecta el servicio de productos.
     *
     * @param ProductoServiceInterface $productoService
     */
    public function __construct(ProductoServiceInterface $productoService)
    {
        $this->productoService = $productoService;
    }

    /**
     * Muestra todos los productos con sus categorías.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $productos = $this->productoService->obtenerTodosConCategoria();
        return view('admin.producto.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.producto.create');
    }

    /**
     * Guarda un nuevo producto y su categoría.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        return $this->productoService->crearProductoYCategoria($request);
    }

    /**
     * Muestra el formulario para editar un producto.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $producto = $this->productoService->obtenerPorIdConCategoria($id);
        return view('admin.producto.edit', compact('producto'));
    }

    /**
     * Actualiza un producto y su categoría.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        return $this->productoService->actualizarProductoYCategoria($request, $id);
    }

    /**
     * Elimina un producto y su categoría.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        return $this->productoService->eliminarProductoYCategoria($id);
    }
}

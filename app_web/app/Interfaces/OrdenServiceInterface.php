<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface OrdenServiceInterface
{
    public function obtenerTodas();
    public function obtenerPorId($id);
    public function crear(array $datos);
    public function actualizar($id, array $datos);
    public function eliminar($id);

    /**
     * Crea una nueva orden a partir de los productos en el carrito.
     *
     * @param array $carrito Array de productos con idProducto, cantidad, descripcion, precio, etc.
     * @param int $usuarioId ID del usuario que está realizando la orden.
     * @return void
     */
    public function crearOrdenDesdeCarrito(array $carrito, int $usuarioId): void;
}

<?php

namespace App\Services;

use App\Interfaces\ProductoServiceInterface;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Servicio para gestionar productos y sus respectivas categorías.
 * 
 * @package App\Services
 */
class ProductoService implements ProductoServiceInterface
{
    /**
     * Obtiene todos los productos con su categoría asociada.
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function obtenerTodosConCategoria()
    {
        return Producto::with('categoria')->get();
    }

    /**
     * Crea un producto y su categoría asociada.
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function crearProductoYCategoria(Request $request)
    {
        DB::beginTransaction();

        try {
            $producto = Producto::create([
                'Precio' => $request->precio,
                'Disponibilidad' => $request->cantidad > 0 ? 1 : 0,
                'Cantidad' => $request->cantidad,
                'CodigoNis_idCodigoNis' => null,
                'Categoria_idCategoria' => null,
            ]);

            $imagenes = [];
            $carpeta = public_path('fotosProductos/');

            for ($i = 1; $i <= 3; $i++) {
                $archivo = $request->file("imagen$i");
                if ($archivo) {
                    $nombre = time() . "_img{$i}_" . $archivo->getClientOriginalName();
                    $archivo->move($carpeta, $nombre);
                    $imagenes[] = $nombre;
                } else {
                    $imagenes[] = null;
                }
            }

            $categoria = Categoria::create([
                'Nombre' => $request->nombre_categoria,
                'Descripcion' => $request->descripcion,
                'Foto1' => $imagenes[0],
                'Foto2' => $imagenes[1],
                'Foto3' => $imagenes[2],
                'Producto_idProducto' => $producto->idProducto,
            ]);

            $producto->Categoria_idCategoria = $categoria->idCategoria;
            $producto->save();

            DB::commit();

            return redirect()->route('admin.producto.index')->with('success', 'Producto creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error al crear producto: ' . $e->getMessage());
        }
    }

    /**
     * Obtiene un producto por su ID con su categoría asociada.
     * 
     * @param int $id
     * @return Producto
     */
    public function obtenerPorIdConCategoria(int $id)
    {
        return Producto::with('categoria')->findOrFail($id);
    }

    /**
     * Actualiza un producto y su categoría.
     * 
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
   public function actualizarProductoYCategoria(Request $request, int $id)
{
    $producto = Producto::findOrFail($id);

    $categoria = $producto->categoria;

    if (!$categoria) {
        // Opcional: lanzar excepción o crear categoría nueva
        abort(404, 'Categoría no encontrada para el producto');
    }

    // Actualizar producto
    $producto->update([
        'Precio' => $request->precio,
        'Cantidad' => $request->cantidad,
        'Disponibilidad' => $request->cantidad > 0 ? 1 : 0,
    ]);

    // Inicializar imágenes actuales
    $imagenes = [
        $categoria->Foto1,
        $categoria->Foto2,
        $categoria->Foto3,
    ];

    $carpeta = public_path('fotosProductos/');

    // Procesar imágenes
    for ($i = 1; $i <= 3; $i++) {
        if ($request->hasFile("imagen$i")) {
            $archivo = $request->file("imagen$i");
            if ($archivo->isValid()) {
                $nombre = time() . "_img{$i}_" . $archivo->getClientOriginalName();
                $archivo->move($carpeta, $nombre);
                $imagenes[$i - 1] = $nombre;
            }
        }
    }

    // Actualizar categoría
    $categoria->update([
        'Nombre' => $request->nombre_categoria,
        'Descripcion' => $request->descripcion,
        'Foto1' => $imagenes[0],
        'Foto2' => $imagenes[1],
        'Foto3' => $imagenes[2],
    ]);

    return redirect()->route('admin.producto.index')->with('success', 'Producto actualizado correctamente.');
}



    /**
     * Elimina un producto y su categoría asociada.
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eliminarProductoYCategoria(int $id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->categoria) {
            $producto->categoria->delete();
        }

        $producto->delete();

        return redirect()->route('admin.producto.index')->with('success', 'Producto eliminado correctamente.');
    }
}

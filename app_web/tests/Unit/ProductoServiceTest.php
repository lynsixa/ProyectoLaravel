<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Services\ProductoService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductoServiceTest extends TestCase
{
    use RefreshDatabase;

    protected ProductoService $productoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productoService = new ProductoService();

        // Crear carpeta simulada para imágenes reales
        File::ensureDirectoryExists(public_path('fotosProductos'));
    }

    /** @test */
    public function puede_crear_producto_y_categoria_con_imagenes()
    {
        $request = new Request([
            'precio' => 99.99,
            'cantidad' => 5,
            'nombre_categoria' => 'Bebidas',
            'descripcion' => 'Gaseosas frías',
        ]);

        $imagen1 = UploadedFile::fake()->image('foto1.jpg');
        $imagen2 = UploadedFile::fake()->image('foto2.jpg');
        $imagen3 = UploadedFile::fake()->image('foto3.jpg');

        $request->files->set('imagen1', $imagen1);
        $request->files->set('imagen2', $imagen2);
        $request->files->set('imagen3', $imagen3);

        $response = $this->productoService->crearProductoYCategoria($request);

        $this->assertEquals(302, $response->status());
        $this->assertDatabaseCount('producto', 1);
        $this->assertDatabaseCount('categoria', 1);

        $producto = Producto::first();
        $categoria = Categoria::first();

        $this->assertEquals($producto->idProducto, $categoria->Producto_idProducto);
        $this->assertEquals($categoria->idCategoria, $producto->Categoria_idCategoria);

        // Verifica que los archivos existen
        foreach ([$categoria->Foto1, $categoria->Foto2, $categoria->Foto3] as $foto) {
            $this->assertFileExists(public_path('fotosProductos/' . $foto));
        }
    }

    /** @test */
    public function puede_actualizar_producto_y_categoria_con_nuevas_imagenes()
    {
        // Crear producto y categoría inicial
        $producto = Producto::factory()->create(['Cantidad' => 3]);
        $categoria = Categoria::factory()->create([
            'Producto_idProducto' => $producto->idProducto
        ]);
        $producto->Categoria_idCategoria = $categoria->idCategoria;
        $producto->save();

        $request = new Request([
            'precio' => 50,
            'cantidad' => 0,
            'nombre_categoria' => 'Snacks',
            'descripcion' => 'Papas y dulces',
        ]);

        $imagen1 = UploadedFile::fake()->image('new1.jpg');
        $imagen2 = UploadedFile::fake()->image('new2.jpg');
        $request->files->set('imagen1', $imagen1);
        $request->files->set('imagen2', $imagen2);

        $response = $this->productoService->actualizarProductoYCategoria($request, $producto->idProducto);

        $this->assertEquals(302, $response->status());

        $producto->refresh();
        $categoria->refresh();

        $this->assertEquals(0, $producto->Disponibilidad);
        $this->assertEquals('Snacks', $categoria->Nombre);
        $this->assertEquals('Papas y dulces', $categoria->Descripcion);

        $this->assertNotNull($categoria->Foto1);
        $this->assertNotNull($categoria->Foto2);
        $this->assertFileExists(public_path('fotosProductos/' . $categoria->Foto1));
        $this->assertFileExists(public_path('fotosProductos/' . $categoria->Foto2));
    }

    /** @test */
    public function puede_eliminar_producto_y_su_categoria()
    {
        $producto = Producto::factory()->create();
        $categoria = Categoria::factory()->create([
            'Producto_idProducto' => $producto->idProducto
        ]);
        $producto->Categoria_idCategoria = $categoria->idCategoria;
        $producto->save();

        $response = $this->productoService->eliminarProductoYCategoria($producto->idProducto);

        $this->assertEquals(302, $response->status());
        $this->assertDatabaseMissing('producto', ['idProducto' => $producto->idProducto]);
        $this->assertDatabaseMissing('categoria', ['idCategoria' => $categoria->idCategoria]);
    }

/** @test */
public function puede_obtener_todos_los_productos_con_categorias()
{
    // Crear 3 productos
    $productos = Producto::factory()->count(3)->create();

    // Crear 3 categorias
    $categorias = Categoria::factory()->count(3)->create();

    // Asignar cada categoria a cada producto (sincronizar FK)
    foreach ($productos as $index => $producto) {
        $producto->Categoria_idCategoria = $categorias[$index]->idCategoria;
        $producto->save();
    }

    // Obtener productos con categoria cargada
    $productosConCategorias = $this->productoService->obtenerTodosConCategoria();

    // Filtrar productos con categoria no nula (por seguridad)
    $productosConCategoriaRelacionada = $productosConCategorias->filter(function($producto) {
        return $producto->categoria !== null;
    });

    $this->assertCount(3, $productosConCategoriaRelacionada);
    $this->assertNotNull($productosConCategoriaRelacionada->first()->categoria);
}

/** @test */
public function puede_obtener_producto_por_id_con_categoria()
{
    $categoria = Categoria::factory()->create();

    $producto = Producto::factory()->for($categoria, 'categoria')->create();

    $result = $this->productoService->obtenerPorIdConCategoria($producto->idProducto);

    $this->assertEquals($producto->idProducto, $result->idProducto);
    $this->assertNotNull($result->categoria);
}
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Producto;
use App\Models\NIS;
use App\Models\Categoria; // Asumo que el producto tiene relación con categoría
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductoControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_puede_ver_listado_de_productos()
    {
        $categoria = Categoria::factory()->create();
        $producto = Producto::factory()->create([
            'Categoria_idCategoria' => $categoria->idCategoria,
        ]);

        $response = $this->get(route('admin.producto.index'));

        $response->assertStatus(200);
        $response->assertSee($producto->Nombre);
    }

    public function test_admin_puede_ver_formulario_de_creacion()
    {
        $response = $this->get(route('admin.producto.create'));

        $response->assertStatus(200);
        $response->assertSee('Crear Producto');
    }

  
  public function test_crear_producto_minimo_exitoso()
{
    Storage::fake('public');

    $data = [
        'precio' => 123.456,
        'cantidad' => 10,
        'nombre_categoria' => 'Categoría Test',
        'descripcion' => 'Descripción de prueba',
        'imagen1' => UploadedFile::fake()->image('img1.jpg'),
        'imagen2' => UploadedFile::fake()->image('img2.jpg'),
        'imagen3' => UploadedFile::fake()->image('img3.jpg'),
    ];

    $response = $this->post(route('admin.producto.store'), $data);

    $response->assertStatus(302);

    $this->assertDatabaseHas('producto', [
        'Precio' => $data['precio'],
        'Cantidad' => $data['cantidad'],
        'Disponibilidad' => 1,
    ]);
}

public function test_admin_puede_actualizar_producto()
{
    Storage::fake('public');

    // Crea categoría para usar en el producto
    $categoria = Categoria::factory()->create([
        'Nombre' => 'Categoría Original',
    ]);

    // Crea producto con datos iniciales (ajustados a nombres reales de columnas)
    $producto = Producto::factory()->create([
        'Categoria_idCategoria' => $categoria->idCategoria,
        'Precio' => 100,
        'Cantidad' => 5,
        'Disponibilidad' => 1,
    ]);

    // Datos para actualizar, igual que en creación, claves en minúscula
    $data = [
        'precio' => 150,
        'cantidad' => 20,
        'nombre_categoria' => 'Categoría Actualizada',
        'descripcion' => 'Descripción actualizada',
        'imagen1' => UploadedFile::fake()->image('nuevo1.jpg'),
        'imagen2' => UploadedFile::fake()->image('nuevo2.jpg'),
        'imagen3' => UploadedFile::fake()->image('nuevo3.jpg'),
    ];

    $response = $this->put(route('admin.producto.update', $producto->idProducto), $data);

    $response->assertStatus(302);
    $response->assertRedirect(route('admin.producto.index'));

    // Verifica que el producto se haya actualizado en la base
    $this->assertDatabaseHas('producto', [
        'idProducto' => $producto->idProducto,
        'Precio' => $data['precio'],        // Clave en mayúscula para la DB
        'Cantidad' => $data['cantidad'],
        'Disponibilidad' => 1,
    ]);

    // Verifica que la categoría haya cambiado (si tu lógica crea o actualiza categorías)
    $this->assertDatabaseHas('categoria', [
        'Nombre' => $data['nombre_categoria'],
        'Descripcion' => $data['descripcion'],
    ]);
}



    public function test_admin_puede_eliminar_producto()
    {
        $categoria = Categoria::factory()->create();

        $producto = Producto::factory()->create([
            'Categoria_idCategoria' => $categoria->idCategoria,
        ]);

        $response = $this->delete(route('admin.producto.destroy', $producto->idProducto));

        $response->assertRedirect(route('admin.producto.index'));
        $this->assertDatabaseMissing('producto', [
            'idProducto' => $producto->idProducto,
        ]);
    }
}

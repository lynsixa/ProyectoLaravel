<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    public function definition(): array
    {
        return [
            'Nombre' => $this->faker->word,
            'Descripcion' => $this->faker->sentence,
            'Foto1' => 'categoria_foto1.jpg',
            'Foto2' => 'categoria_foto2.jpg',
            'Foto3' => 'categoria_foto3.jpg',
            'Producto_idProducto' => Producto::factory(),
        ];
    }
}

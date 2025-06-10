<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition(): array
    {
        return [
            'Precio' => $this->faker->randomFloat(3, 1, 100),
            'Disponibilidad' => $this->faker->boolean,
            'Cantidad' => $this->faker->numberBetween(0, 100),
            'CodigoNis_idCodigoNis' => null, // puedes cambiar esto si tienes una tabla codigonis
            'Categoria_idCategoria' => null, // se asignará luego si es necesario
        ];
    }
}

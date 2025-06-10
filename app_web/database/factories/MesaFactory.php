<?php

namespace Database\Factories;

use App\Models\Mesa;
use Illuminate\Database\Eloquent\Factories\Factory;

class MesaFactory extends Factory
{
    protected $model = Mesa::class;

    public function definition(): array
    {
        return [
            'NumeroPiso' => $this->faker->numberBetween(1, 5),
            'NumeroMesa' => $this->faker->numberBetween(1, 50),
        ];
    }
}

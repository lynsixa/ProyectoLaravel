<?php

namespace Database\Factories;

use App\Models\Evento;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventoFactory extends Factory
{
    protected $model = Evento::class;

    public function definition(): array
    {
        return [
            'Titulo' => $this->faker->sentence(5),
            'Descripcion' => $this->faker->text(50), // Máximo permitido por la migración
            'Fecha_Evento' => $this->faker->dateTimeBetween('+1 week', '+6 months'),
        ];
    }
}

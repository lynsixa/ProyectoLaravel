<?php

namespace Database\Factories;

use App\Models\NIS;
use App\Models\Mesa;
use App\Models\Menu;
use App\Models\Evento;
use Illuminate\Database\Eloquent\Factories\Factory;

class NISFactory extends Factory
{
    protected $model = NIS::class;

    public function definition(): array
    {
        return [
            'Descripcion' => $this->faker->sentence(3),
            'Disponibilidad' => $this->faker->boolean(),
            'Mesa_idMesa' => Mesa::factory(),
            'Menu_idMenu' => Menu::factory(),
            'Eventos_idEventos' => $this->faker->boolean(70) ? Evento::factory() : null,
        ];
    }
}

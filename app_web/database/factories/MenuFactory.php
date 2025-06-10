<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    
    protected $model = Menu::class;

    public function definition(): array
    {
        return [
            'Descripcion' => $this->faker->sentence(8), // o $this->faker->text(100)
        ];
    }
}

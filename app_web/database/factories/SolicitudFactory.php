<?php

namespace Database\Factories;

use App\Models\Solicitud;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitudFactory extends Factory
{
    protected $model = Solicitud::class;

    public function definition()
    {
        return [
            'Descripcion' => $this->faker->sentence,
            'Informe' => $this->faker->paragraph,
            'Despachado' => 0, // estado pendiente por defecto
            'Entrega_idEntrega' => null, // si quieres simular con relación, puedes usar Entrega::factory()
        ];
    }

    public function procesada()
    {
        return $this->state(['Despachado' => 1]);
    }

    public function rechazada()
    {
        return $this->state(['Despachado' => -1]);
    }
}

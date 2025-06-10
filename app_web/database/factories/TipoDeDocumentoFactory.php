<?php

namespace Database\Factories;

use App\Models\TipoDeDocumento;
use Illuminate\Database\Eloquent\Factories\Factory;

class TipoDeDocumentoFactory extends Factory
{
    protected $model = TipoDeDocumento::class;

    public function definition(): array
    {
        return [
            'Descripcion' => $this->faker->word,
        ];
    }
}

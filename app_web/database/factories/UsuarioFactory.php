<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            'Nombres' => $this->faker->firstName(),
            'Apellidos' => $this->faker->lastName(),
            'Documento' => $this->faker->numerify('##########'),
            'Correo' => $this->faker->unique()->safeEmail(),
            'Contraseña' => bcrypt('password'),
            'FechaDeNacimiento' => $this->faker->date(),
            'token' => Str::random(40),
            'token_password' => Str::random(60),
            'password_request' => 0, // ← importante
            'Tipo_de_documento_idTipodedocumento' => 1,
            'Roles_idRoles' => 1,
            'CodigoNis_idCodigoNis' => null,
        ];
    }
}


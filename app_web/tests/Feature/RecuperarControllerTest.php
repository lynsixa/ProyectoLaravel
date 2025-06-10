<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use App\Models\TipoDeDocumento;
use App\Models\Rol;
use App\Models\NIS;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RecuperarControllerTest extends TestCase
{
    use RefreshDatabase;

    private function crearRelacionesRequeridas()
    {
        $tipoDoc = TipoDeDocumento::factory()->create();
        $rol = Rol::factory()->create();
        $codigoNis = NIS::factory()->create();

        return [
            'Tipo_de_documento_idTipodedocumento' => $tipoDoc->idTipodedocumento,
            'Roles_idRoles' => $rol->idRoles,
            'CodigoNis_idCodigoNis' => $codigoNis->idCodigoNis,
        ];
    }

    /** @test */
    public function muestra_el_formulario_de_recuperacion()
    {
        $response = $this->get('/recuperar');
        $response->assertStatus(200);
        $response->assertViewIs('auth.recupera');
    }

    /** @test */
    public function envia_correo_de_recuperacion_con_email_valido()
    {
        Mail::fake();

        $relaciones = $this->crearRelacionesRequeridas();

        $usuario = Usuario::factory()->create(array_merge([
            'Correo' => 'test@example.com',
        ], $relaciones));

        $response = $this->post('/recuperar', ['email' => 'test@example.com']);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('mensaje');

        $this->assertDatabaseHas('usuario', [
            'idUsuario' => $usuario->idUsuario,
            'password_request' => 1,
        ]);
    }

    /** @test */
    public function no_envia_correo_si_el_email_no_existe()
    {
        Mail::fake();

        $response = $this->post('/recuperar', ['email' => 'inexistente@example.com']);

        $response->assertSessionHas('error', 'No se encontró un usuario con ese correo.');
    }

    /** @test */
    public function muestra_formulario_de_cambio_de_contrasena_con_token_valido()
    {
        $relaciones = $this->crearRelacionesRequeridas();

        $usuario = Usuario::factory()->create(array_merge([
            'token_password' => Str::random(60),
            'password_request' => 1,
        ], $relaciones));

        $response = $this->get("/recuperar/cambiar/{$usuario->idUsuario}/{$usuario->token_password}");

        $response->assertStatus(200);
        $response->assertViewIs('auth.cambiar_password');
    }

    /** @test */
    public function no_muestra_formulario_si_el_token_es_invalido()
    {
        $relaciones = $this->crearRelacionesRequeridas();

        $usuario = Usuario::factory()->create(array_merge([
            'token_password' => 'token_real',
            'password_request' => 1,
        ], $relaciones));

        $response = $this->get("/recuperar/cambiar/{$usuario->idUsuario}/token_falso");

        $response->assertStatus(404);
    }

    /** @test */
    public function actualiza_la_contrasena_con_datos_validos()
    {
        $token = Str::random(60);
        $relaciones = $this->crearRelacionesRequeridas();

        $usuario = Usuario::factory()->create(array_merge([
            'token_password' => $token,
            'password_request' => 1,
        ], $relaciones));

        $response = $this->post('/recuperar/cambiar', [
            'id' => $usuario->idUsuario,
            'token' => $token,
            'password' => 'nueva123',
            'password_confirmation' => 'nueva123',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('mensaje');

        // Ahora debe buscar en la tabla 'usuario' (singular)
        $this->assertDatabaseMissing('usuario', [
            'idUsuario' => $usuario->idUsuario,
            'token_password' => $token,
        ]);

        $usuario->refresh();
        $this->assertTrue(Hash::check('nueva123', $usuario->Contraseña));
    }

    /** @test */
    public function no_actualiza_contrasena_con_token_invalido()
    {
        $relaciones = $this->crearRelacionesRequeridas();

        $usuario = Usuario::factory()->create(array_merge([
            'token_password' => Str::random(60),
            'password_request' => 1,
        ], $relaciones));

        $response = $this->post('/recuperar/cambiar', [
            'id' => $usuario->idUsuario,
            'token' => 'token_falso',
            'password' => 'nueva123',
            'password_confirmation' => 'nueva123',
        ]);

        $response->assertSessionHas('error', 'Token inválido o expirado.');
    }
}

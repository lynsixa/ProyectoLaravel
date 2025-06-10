<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use App\Models\TipoDeDocumento;
use App\Models\NIS;
use App\Models\Rol;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsuarioIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_usuario()
    {
        $tipo = TipoDeDocumento::factory()->create();
        $rol = Rol::factory()->create();

        $response = $this->post(route('admin.usuario.store'), [
            'Nombres' => 'Juan',
            'Apellidos' => 'Pérez',
            'Documento' => '123456789',
            'Correo' => 'juan@example.com',
            'Contraseña' => 'password123',
            'Contraseña_confirmation' => 'password123',
            'FechaDeNacimiento' => '2000-01-01',
            'Tipo_de_documento_idTipodedocumento' => $tipo->idTipodedocumento,
            'Roles_idRoles' => $rol->idRoles,
        ]);

        $response->assertRedirect(route('admin.usuario.index'));
        $this->assertDatabaseHas('usuario', [
            'Correo' => 'juan@example.com',
            'Nombres' => 'Juan',
        ]);
    }

    public function test_puede_actualizar_usuario()
    {
        $tipo = TipoDeDocumento::factory()->create();
        $rol = Rol::factory()->create();

        $usuario = Usuario::factory()->create([
            'Tipo_de_documento_idTipodedocumento' => $tipo->idTipodedocumento,
            'Roles_idRoles' => $rol->idRoles,
        ]);

        $response = $this->put(route('admin.usuario.update', $usuario->idUsuario), [
            'Nombres' => 'Carlos',
            'Apellidos' => 'García',
            'Documento' => $usuario->Documento,
            'Correo' => $usuario->Correo,
            'FechaDeNacimiento' => $usuario->FechaDeNacimiento,
            'Tipo_de_documento_idTipodedocumento' => $tipo->idTipodedocumento,
            'Roles_idRoles' => $rol->idRoles,
            'Contraseña' => '', // no cambiar contraseña
            'Contraseña_confirmation' => '',
        ]);

        $response->assertRedirect(route('admin.usuario.index'));

        $this->assertDatabaseHas('usuario', [
            'idUsuario' => $usuario->idUsuario,
            'Nombres' => 'Carlos',
        ]);
    }

    public function test_puede_eliminar_usuario()
    {
         $tipo = \App\Models\TipoDeDocumento::factory()->create();
    $rol = \App\Models\Rol::factory()->create();
    $codigoNis = \App\Models\NIS::factory()->create();

    $usuario = \App\Models\Usuario::factory()->create([
        'Tipo_de_documento_idTipodedocumento' => $tipo->idTipodedocumento,
        'Roles_idRoles' => $rol->idRoles,
        'CodigoNis_idCodigoNis' => $codigoNis->idNIS,
    ]);

    // Simula una petición DELETE al endpoint correspondiente
    $response = $this->delete(route('admin.usuario.destroy', $usuario->idUsuario));

    // Verifica que redirige correctamente
    $response->assertRedirect(route('admin.usuario.index'));

    // Verifica que el usuario ya no existe en la base de datos
    $this->assertDatabaseMissing('usuario', [
        'idUsuario' => $usuario->idUsuario,
    ]);
    }
}

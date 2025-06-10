<?php

namespace Tests\Unit;

use App\Models\Usuario;
use App\Models\TipoDeDocumento;
use App\Models\Rol;
use App\Services\UsuarioService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tests\TestCase;

class UsuarioServiceTest extends TestCase
{
    use RefreshDatabase;

    protected UsuarioService $usuarioService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->usuarioService = new UsuarioService();
    }

    /** @test */
    public function puede_crear_un_usuario()
    {
        $tipo = TipoDeDocumento::factory()->create();
        $rol = Rol::factory()->create();

        $request = Request::create('/fake-url', 'POST', [
            'Nombres' => 'Juan',
            'Apellidos' => 'Pérez',
            'Documento' => '12345678',
            'Correo' => 'juan@example.com',
            'Contraseña' => 'password123',
            'Contraseña_confirmation' => 'password123',
            'FechaDeNacimiento' => '2000-01-01',
            'Tipo_de_documento_idTipodedocumento' => $tipo->idTipodedocumento,
            'Roles_idRoles' => $rol->idRoles,
        ]);

        $this->usuarioService->crearUsuario($request);

        $this->assertDatabaseHas('usuario', [
            'Correo' => 'juan@example.com',
            'Nombres' => 'Juan',
        ]);
    }

    /** @test */
   public function puede_obtener_todos_los_usuarios()
{
    $tipo = \App\Models\TipoDeDocumento::factory()->create();
    $rol = \App\Models\Rol::factory()->create();
    $codigoNis = \App\Models\NIS::factory()->create();

    \App\Models\Usuario::factory()->count(3)->create([
        'Tipo_de_documento_idTipodedocumento' => $tipo->idTipodedocumento,
        'Roles_idRoles' => $rol->idRoles,
        'CodigoNis_idCodigoNis' => $codigoNis->idNIS,
    ]);

    $usuarios = $this->usuarioService->obtenerTodos();

    $this->assertCount(3, $usuarios);
}

    /** @test */
    public function puede_obtener_tipos_y_roles()
    {
        TipoDeDocumento::factory()->count(2)->create();
        Rol::factory()->count(2)->create();

        $data = $this->usuarioService->obtenerTiposYRoles();

        $this->assertCount(2, $data['tipos']);
        $this->assertCount(2, $data['roles']);
    }

    /** @test */
    public function puede_actualizar_un_usuario()
    {
        $tipo = TipoDeDocumento::factory()->create();
        $rol = Rol::factory()->create();

        $usuario = Usuario::factory()->create([
            'Tipo_de_documento_idTipodedocumento' => $tipo->idTipodedocumento,
            'Roles_idRoles' => $rol->idRoles,
        ]);

        $request = Request::create('/fake-url', 'PUT', [
            'Nombres' => 'NombreNuevo',
            'Apellidos' => $usuario->Apellidos,
            'Documento' => $usuario->Documento,
            'Correo' => $usuario->Correo,
            'FechaDeNacimiento' => $usuario->FechaDeNacimiento,
            'Tipo_de_documento_idTipodedocumento' => $tipo->idTipodedocumento,
            'Roles_idRoles' => $rol->idRoles,
        ]);

        $this->usuarioService->actualizarUsuario($request, $usuario->idUsuario);

        $this->assertDatabaseHas('usuario', ['idUsuario' => $usuario->idUsuario, 'Nombres' => 'NombreNuevo']);
    }

    /** @test */
    public function puede_eliminar_un_usuario()
{
    $tipo = \App\Models\TipoDeDocumento::factory()->create();
    $rol = \App\Models\Rol::factory()->create();
    $codigoNis = \App\Models\NIS::factory()->create();

    $usuario = \App\Models\Usuario::factory()->create([
        'Tipo_de_documento_idTipodedocumento' => $tipo->idTipodedocumento,
        'Roles_idRoles' => $rol->idRoles,
        'CodigoNis_idCodigoNis' => $codigoNis->idNIS,
    ]);

    $this->usuarioService->eliminarUsuario($usuario->idUsuario);

    $this->assertDatabaseMissing('usuario', ['idUsuario' => $usuario->idUsuario]);
}
}

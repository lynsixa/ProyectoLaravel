<?php

namespace Tests\Unit;

use App\Models\Rol;
use App\Services\RolService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class RolServiceTest extends TestCase
{
    use RefreshDatabase;

    protected RolService $rolService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->rolService = new RolService();
    }

    /** @test */
    public function puede_obtener_todos_los_roles()
    {
        Rol::factory()->count(3)->create();

        $roles = $this->rolService->obtenerTodos();

        $this->assertCount(3, $roles);
    }

    /** @test */
    public function puede_obtener_un_rol_por_id()
    {
        $rol = Rol::factory()->create();

        $rolObtenido = $this->rolService->obtenerPorId($rol->idRoles);

        $this->assertEquals($rol->idRoles, $rolObtenido->idRoles);
        $this->assertEquals($rol->Descripcion, $rolObtenido->Descripcion);
    }

    /** @test */
    public function puede_actualizar_un_rol()
    {
        $rol = Rol::factory()->create([
            'Descripcion' => 'Administrador',
        ]);

        $request = Request::create('/fake-url', 'PUT', [
            'Descripcion' => 'Supervisor',
        ]);

        $this->rolService->actualizar($request, $rol->idRoles);

        $this->assertDatabaseHas('roles', [
            'idRoles' => $rol->idRoles,
            'Descripcion' => 'Supervisor',
        ]);
    }

    /** @test */
    public function puede_eliminar_un_rol()
    {
        $rol = Rol::factory()->create();

        $this->rolService->eliminar($rol->idRoles);

        $this->assertDatabaseMissing('roles', [
            'idRoles' => $rol->idRoles,
        ]);
    }
}

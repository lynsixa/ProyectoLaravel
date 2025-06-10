<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Mesa;
use App\Services\MesaService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MesaServiceTest extends TestCase
{
    use RefreshDatabase;

    protected MesaService $mesaService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mesaService = new MesaService();
    }

    public function test_puede_obtener_todas_las_mesas()
    {
        Mesa::factory()->count(3)->create();

        $mesas = $this->mesaService->obtenerTodas();

        $this->assertCount(3, $mesas);
    }

    public function test_puede_crear_una_mesa()
    {
        $data = [
            'NumeroPiso' => 2,
            'NumeroMesa' => 15,
        ];

        $mesa = $this->mesaService->crear($data);

        $this->assertDatabaseHas('mesa', [
            'idMesa' => $mesa->idMesa,
            'NumeroPiso' => 2,
            'NumeroMesa' => 15,
        ]);
    }

    public function test_puede_obtener_una_mesa_por_id()
    {
        $mesa = Mesa::factory()->create();

        $resultado = $this->mesaService->obtenerPorId($mesa->idMesa);

        $this->assertEquals($mesa->idMesa, $resultado->idMesa);
    }

    public function test_puede_actualizar_una_mesa()
    {
        $mesa = Mesa::factory()->create([
            'NumeroPiso' => 1,
            'NumeroMesa' => 5,
        ]);

        $data = [
            'NumeroPiso' => 3,
            'NumeroMesa' => 20,
        ];

        $actualizada = $this->mesaService->actualizar($mesa->idMesa, $data);

        $this->assertEquals(3, $actualizada->NumeroPiso);
        $this->assertEquals(20, $actualizada->NumeroMesa);

        $this->assertDatabaseHas('mesa', [
            'idMesa' => $mesa->idMesa,
            'NumeroPiso' => 3,
            'NumeroMesa' => 20,
        ]);
    }

    public function test_puede_eliminar_una_mesa()
    {
        $mesa = Mesa::factory()->create();

        $this->mesaService->eliminar($mesa->idMesa);

        $this->assertDatabaseMissing('mesa', ['idMesa' => $mesa->idMesa]);
    }
}

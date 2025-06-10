<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\NIS;
use App\Models\Mesa;
use App\Models\Menu;
use App\Models\Evento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use App\Services\NISService;

class NISServiceTest extends TestCase
{
    use RefreshDatabase;

    protected NISService $nisService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->nisService = new NISService();
    }

    public function test_puede_obtener_todos_los_nis()
    {
        NIS::factory()->count(3)->create();
        $nis = $this->nisService->obtenerTodos();
        $this->assertCount(3, $nis);
    }

    public function test_puede_obtener_un_nis_por_id()
    {
        $nis = NIS::factory()->create();
        $resultado = $this->nisService->obtenerPorId($nis->idCodigoNis);
        $this->assertEquals($nis->idCodigoNis, $resultado->idCodigoNis);
    }

    public function test_puede_crear_un_nis()
    {
        $mesa = Mesa::factory()->create(['NumeroPiso' => 1, 'NumeroMesa' => 10]);
        $menu = Menu::factory()->create();
        $evento = Evento::factory()->create();

        $request = Request::create('/nis', 'POST', [
            'descripcion' => 'Mesa Piso 1',
            'numero_piso' => 1,
            'numero_mesa' => 10,
            'menu_id' => $menu->idMenu,
            'eventos_id' => $evento->idEventos,
        ]);

        $this->nisService->crear($request);

        $this->assertDatabaseHas('codigonis', [
            'Descripcion' => 'Mesa Piso 1',
            'Menu_idMenu' => $menu->idMenu,
            'Eventos_idEventos' => $evento->idEventos,
            'Disponibilidad' => 1,
        ]);
    }

    public function test_puede_actualizar_un_nis()
    {
        $mesa = Mesa::factory()->create(['NumeroPiso' => 1, 'NumeroMesa' => 5]);
        $menu = Menu::factory()->create();
        $evento = Evento::factory()->create();

        $nis = NIS::factory()->create([
            'Descripcion' => 'Antigua Desc',
            'Mesa_idMesa' => $mesa->idMesa,
            'Menu_idMenu' => $menu->idMenu,
            'Eventos_idEventos' => $evento->idEventos,
            'Disponibilidad' => 1,
        ]);

        $nuevoMenu = Menu::factory()->create();
        $nuevoEvento = Evento::factory()->create();

        $request = Request::create('/nis/' . $nis->idCodigoNis, 'PUT', [
            'descripcion' => 'Nueva Desc',
            'numero_piso' => 1,
            'menu_id' => $nuevoMenu->idMenu,
            'eventos_id' => $nuevoEvento->idEventos,
            'disponibilidad' => false,
        ]);

        $this->nisService->actualizar($nis->idCodigoNis, $request);

        $this->assertDatabaseHas('codigonis', [
            'idCodigoNis' => $nis->idCodigoNis,
            'Descripcion' => 'Nueva Desc',
            'Menu_idMenu' => $nuevoMenu->idMenu,
            'Eventos_idEventos' => $nuevoEvento->idEventos,
            'Disponibilidad' => 0,
        ]);
    }

    public function test_puede_eliminar_un_nis()
    {
        $nis = NIS::factory()->create();
        $this->nisService->eliminar($nis->idCodigoNis);
        $this->assertDatabaseMissing('codigonis', ['idCodigoNis' => $nis->idCodigoNis]);
    }
}

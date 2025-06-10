<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Evento;
use App\Services\EventoService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventoServiceTest extends TestCase
{
    use RefreshDatabase;

    protected EventoService $eventoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventoService = new EventoService();
    }

    public function test_puede_obtener_todos_los_eventos()
    {
        Evento::factory()->count(3)->create();

        $eventos = $this->eventoService->obtenerTodos();

        $this->assertCount(3, $eventos);
        $this->assertEquals(
            Evento::orderBy('Fecha_Evento', 'asc')->pluck('idEventos')->toArray(),
            $eventos->pluck('idEventos')->toArray()
        );
    }

    public function test_puede_crear_un_evento()
    {
        $data = [
            'titulo' => 'Evento de Prueba',
            'descripcion' => 'Descripción del evento',
            'fecha_evento' => now()->addDays(10)->toDateTimeString(),
        ];

        $evento = $this->eventoService->crear($data);

        $this->assertDatabaseHas('eventos', [
            'idEventos' => $evento->idEventos,
            'Titulo' => 'Evento de Prueba',
            'Descripcion' => 'Descripción del evento',
        ]);
    }

    public function test_puede_obtener_evento_por_id()
    {
        $evento = Evento::factory()->create();

        $resultado = $this->eventoService->obtenerPorId($evento->idEventos);

        $this->assertEquals($evento->idEventos, $resultado->idEventos);
    }

    public function test_puede_actualizar_un_evento()
    {
        $evento = Evento::factory()->create();

        $data = [
            'titulo' => 'Nuevo Título',
            'descripcion' => 'Nueva descripción',
            'fecha_evento' => now()->addMonth()->toDateTimeString(),
        ];

        $this->eventoService->actualizar($evento->idEventos, $data);

        $this->assertDatabaseHas('eventos', [
            'idEventos' => $evento->idEventos,
            'Titulo' => 'Nuevo Título',
            'Descripcion' => 'Nueva descripción',
        ]);
    }

    public function test_puede_eliminar_un_evento()
    {
        $evento = Evento::factory()->create();

        $this->eventoService->eliminar($evento->idEventos);

        $this->assertDatabaseMissing('eventos', ['idEventos' => $evento->idEventos]);
    }
}

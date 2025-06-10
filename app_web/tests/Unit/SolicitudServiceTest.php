<?php

namespace Tests\Unit;

use App\Models\Solicitud;
use App\Services\SolicitudService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SolicitudServiceTest extends TestCase
{
    use RefreshDatabase;

    protected SolicitudService $solicitudService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->solicitudService = new SolicitudService();
    }

    /** @test */
    public function puede_obtener_solicitudes_pendientes()
    {
        Solicitud::factory()->count(3)->create(['Despachado' => 0]);
        Solicitud::factory()->count(2)->procesada()->create();
        Solicitud::factory()->count(1)->rechazada()->create();

        $pendientes = $this->solicitudService->obtenerSolicitudesPendientes();

        $this->assertCount(3, $pendientes);
        $this->assertTrue($pendientes->every(fn($s) => $s->Despachado === 0));
    }

    /** @test */
    public function puede_obtener_solicitudes_procesadas()
    {
        Solicitud::factory()->count(3)->procesada()->create();
        Solicitud::factory()->count(2)->rechazada()->create();
        Solicitud::factory()->count(1)->create(['Despachado' => 0]);

        $procesadas = $this->solicitudService->obtenerSolicitudesProcesadas();

        $this->assertCount(5, $procesadas);
        $this->assertTrue($procesadas->every(fn($s) => in_array($s->Despachado, [1, -1])));
    }

    /** @test */
    public function puede_despachar_una_solicitud()
    {
        $solicitud = Solicitud::factory()->create(['Despachado' => 0]);

        $this->solicitudService->despachar($solicitud->idSolicitud);

        $this->assertDatabaseHas('solicitud', [
            'idSolicitud' => $solicitud->idSolicitud,
            'Despachado' => 1,
        ]);
    }

    /** @test */
    public function puede_rechazar_una_solicitud_con_motivo()
    {
        $solicitud = Solicitud::factory()->create(['Despachado' => 0, 'Informe' => 'Inicial']);

        $this->solicitudService->rechazar($solicitud->idSolicitud, 'Motivo de rechazo');

        $this->assertDatabaseHas('solicitud', [
            'idSolicitud' => $solicitud->idSolicitud,
            'Despachado' => -1,
        ]);

        $solicitud->refresh();
        $this->assertStringContainsString('Motivo: Motivo de rechazo', $solicitud->Informe);
    }
}

<?php

namespace Tests\Unit;

use App\Models\Evento;
use App\Services\CalendarioService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarioServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CalendarioService $calendarioService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calendarioService = new CalendarioService();
    }

    /** @test */
    public function puede_obtener_eventos_entre_dos_fechas()
    {
        // Crear eventos dentro y fuera del rango
        Evento::factory()->create([
            'Titulo' => 'Evento dentro',
            'Fecha_Evento' => '2025-06-15',
        ]);

        Evento::factory()->create([
            'Titulo' => 'Evento fuera',
            'Fecha_Evento' => '2025-07-20',
        ]);

        $eventos = $this->calendarioService->obtenerEventosEntreFechas('2025-06-01', '2025-06-30');

        $this->assertCount(1, $eventos);
        $this->assertEquals('Evento dentro', $eventos[0]['title']);
        $this->assertEquals('2025-06-15', $eventos[0]['start']);
    }

    /** @test */
    public function retorna_lista_vacia_si_no_hay_eventos_en_el_rango()
    {
        Evento::factory()->create(['Fecha_Evento' => '2025-08-01']);

        $eventos = $this->calendarioService->obtenerEventosEntreFechas('2025-06-01', '2025-06-30');

        $this->assertEmpty($eventos);
    }
}

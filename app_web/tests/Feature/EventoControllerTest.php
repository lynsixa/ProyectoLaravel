<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Evento;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventoControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_listar_los_eventos()
    {
        // Crear algunos eventos con factory
        Evento::factory()->count(3)->create();

        // Petición GET al index
        $response = $this->get(route('admin.eventos.index'));

        // Comprobar que la vista carga correctamente y contiene los eventos
        $response->assertStatus(200);
        $response->assertViewHas('eventos');
    }

    /** @test */
    public function puede_crear_un_evento()
    {
        $data = [
            'titulo' => 'Evento de prueba',
            'descripcion' => 'Descripción del evento de prueba',
            'fecha_evento' => now()->addDays(10)->format('Y-m-d'),
        ];

        $response = $this->post(route('admin.eventos.store'), $data);

        $response->assertRedirect(route('admin.eventos.index'));

        $this->assertDatabaseHas('eventos', [
            'Titulo' => $data['titulo'],
            'Descripcion' => $data['descripcion'],
            'Fecha_Evento' => $data['fecha_evento'],
        ]);
    }

    /** @test */
    public function puede_mostrar_el_formulario_de_edicion()
    {
        $evento = Evento::factory()->create();

        $response = $this->get(route('admin.eventos.edit', ['evento' => $evento->idEventos]));

        $response->assertStatus(200);
        $response->assertViewHas('evento');
    }

    /** @test */
    public function puede_actualizar_un_evento()
    {
        $evento = Evento::factory()->create();

        $data = [
            'titulo' => 'Evento actualizado',
            'descripcion' => 'Descripción actualizada',
            'fecha_evento' => now()->addDays(20)->format('Y-m-d'),
        ];

        $response = $this->put(route('admin.eventos.update', ['evento' => $evento->idEventos]), $data);

        $response->assertRedirect(route('admin.eventos.index'));

        $this->assertDatabaseHas('eventos', [
            'idEventos' => $evento->idEventos,
            'Titulo' => $data['titulo'],
            'Descripcion' => $data['descripcion'],
            'Fecha_Evento' => $data['fecha_evento'],
        ]);
    }

    /** @test */
    public function puede_eliminar_un_evento()
    {
        $evento = Evento::factory()->create();

        $response = $this->delete(route('admin.eventos.destroy', ['evento' => $evento->idEventos]));

        $response->assertRedirect(route('admin.eventos.index'));

        $this->assertDatabaseMissing('eventos', ['idEventos' => $evento->idEventos]);
    }
}

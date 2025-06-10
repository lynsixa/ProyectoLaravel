<?php

namespace Tests\Feature;

use App\Models\NIS;
use App\Models\Mesa;
use App\Models\Menu;
use App\Models\Evento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NISControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_muestra_vista_con_nis()
    {
        NIS::factory()->count(3)->create();

        $response = $this->get(route('admin.nis.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.nis.index');
        $response->assertViewHas('nis');
    }

public function test_puede_crear_un_nis()
{
    $mesa = Mesa::factory()->create();
    $menu = Menu::factory()->create();
    $evento = Evento::factory()->create();

    $data = [
        'descripcion' => 'NIS de prueba',
        'disponibilidad' => true,
        'numero_piso' => $mesa->NumeroPiso,
        'numero_mesa' => $mesa->NumeroMesa,
        'menu_id' => $menu->idMenu, // <-- campo que espera el servicio
        'eventos_id' => $evento->idEventos, // <-- asegúrate que así lo espera tu lógica
    ];

    $response = $this->post(route('admin.nis.store'), $data);

    $response->assertRedirect(route('admin.nis.index'));
    $this->assertDatabaseHas('codigonis', ['Descripcion' => 'NIS de prueba']);
}


public function test_puede_actualizar_un_nis()
{
    $nis = NIS::factory()->create();

    // Obtener el piso y mesa actuales asociados al NIS
    $pisoActual = $nis->Mesa->NumeroPiso;
    $mesaActual = $nis->Mesa->NumeroMesa;

    // Crear mesa que coincida con el nuevo piso y el mismo número de mesa
    $mesaNueva = Mesa::factory()->create([
        'NumeroPiso' => $pisoActual + 1,
        'NumeroMesa' => $mesaActual,
    ]);

    $data = [
        'descripcion' => 'NIS actualizado',
        'disponibilidad' => true,
        'numero_piso' => $mesaNueva->NumeroPiso,  // ahora sí existe
        'numero_mesa' => $mesaNueva->NumeroMesa,
        'menu_id' => $nis->Menu_idMenu,
        'eventos_id' => $nis->Eventos_idEventos,
    ];

    $response = $this->put(route('admin.nis.update', ['nis' => $nis->idCodigoNis]), $data);

    $response->assertRedirect(route('admin.nis.index'));
    $this->assertDatabaseHas('codigonis', [
        'idCodigoNis' => $nis->idCodigoNis,
        'Descripcion' => 'NIS actualizado',
    ]);
}

public function test_puede_eliminar_un_nis()
{
    $nis = NIS::factory()->create();

    $response = $this->delete(route('admin.nis.destroy', ['nis' => $nis->idCodigoNis]));

    $response->assertRedirect(route('admin.nis.index'));
    $this->assertDatabaseMissing('codigonis', ['idCodigoNis' => $nis->idCodigoNis]);
}


}

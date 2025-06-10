<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\Informes\InformeUsuarioGerenteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Usuario;
use App\Models\TipoDeDocumento;
use App\Models\Rol;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test; // Solo si estás usando PHPUnit >= 10

class InformeUsuarioGerenteServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test] // Usa esto en lugar de `/** @test */` si tienes PHPUnit >= 10
    public function genera_excel_con_usuarios_y_retorna_archivo_para_descarga(): void
    {
        Storage::fake('public');

       $tipo = TipoDeDocumento::factory()->create();
        $rol = Rol::factory()->create();

        Usuario::factory()->create([
            'Nombres' => 'Juan',
            'Apellidos' => 'Pérez',
            'Documento' => '12345678',
            'Correo' => 'juan@example.com',
            'Tipo_de_documento_idTipodedocumento' => $tipo->idTipodedocumento,
            'Roles_idRoles' => $rol->idRoles,
        ]);

        $service = new InformeUsuarioGerenteService();

        $response = $service->generarExcel();

        $this->assertInstanceOf(BinaryFileResponse::class, $response);
        $this->assertFileExists(storage_path('app/public/informe_usuarios.xlsx'));

        // Limpieza opcional
        unlink(storage_path('app/public/informe_usuarios.xlsx'));
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Usuario;
use App\Models\Rol;
use App\Models\TipoDeDocumento;
use App\Models\NIS;
use App\Services\InformeAdminService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PHPUnit\Framework\Attributes\Test;

class InformeAdminServiceTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function genera_datos_excel_con_usuarios()
    {
        // Crear relaciones necesarias
        $rol = Rol::factory()->create(['Descripcion' => 'Admin']);
        $tipoDoc = TipoDeDocumento::factory()->create(['Descripcion' => 'CC']);
        $codigoNis = NIS::factory()->create();

        // Crear usuario utilizando la factory y los IDs correctos
        Usuario::factory()->create([
            'Roles_idRoles' => $rol->idRoles,
            'Tipo_de_documento_idTipodedocumento' => $tipoDoc->idTipodedocumento,
            'CodigoNis_idCodigoNis' => $codigoNis->idCodigoNis,
        ]);

        $servicio = new InformeAdminService();
        $spreadsheet = $servicio->generarDatosExcel();

        $this->assertInstanceOf(Spreadsheet::class, $spreadsheet);

        $sheet = $spreadsheet->getActiveSheet();
        $this->assertInstanceOf(Worksheet::class, $sheet);
        $this->assertEquals('Usuarios', $sheet->getTitle());

        // Verifica encabezados
        $this->assertEquals('Nombres', $sheet->getCell('A1')->getValue());
        $this->assertEquals('Apellidos', $sheet->getCell('B1')->getValue());

        // Verifica contenido en fila 2
        $this->assertNotEmpty($sheet->getCell('A2')->getValue());
    }
}

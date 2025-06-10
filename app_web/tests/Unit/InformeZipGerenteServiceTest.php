<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery;
use Illuminate\Support\Facades\Storage;
use App\Services\Informes\InformeZipGerenteService;
use App\Interfaces\Informes\InformeUsuarioGerenteServiceInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class InformeZipGerenteServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
    }

    public function tearDown(): void
    {
        // Eliminar archivos si quedaron
        $zipPath = storage_path('app/public/informes.zip');
        $excelPath = storage_path('app/public/informe_usuarios.xlsx');

        if (file_exists($zipPath)) {
            unlink($zipPath);
        }
        if (file_exists($excelPath)) {
            unlink($excelPath);
        }

        parent::tearDown();
        Mockery::close();
    }

    /** @test */
    public function genera_zip_con_excel_de_usuarios()
    {
        // Crear Excel ficticio
        $excelPath = storage_path('app/public/informe_usuarios.xlsx');
        File::put($excelPath, 'contenido de prueba');

        // Mock del servicio de usuarios
        $usuarioServiceMock = Mockery::mock(InformeUsuarioGerenteServiceInterface::class);
        $usuarioServiceMock->shouldReceive('generarExcel')->once()->andReturn(
            response()->download($excelPath)
        );

        // Instanciar servicio principal
        $zipService = new InformeZipGerenteService($usuarioServiceMock);

        // Ejecutar
        $response = $zipService->generarZip();

        // Verificar
        $this->assertInstanceOf(BinaryFileResponse::class, $response);
        $this->assertFileExists(storage_path('app/public/informes.zip'));

        // Verifica que el ZIP contenga el Excel
        $zip = new \ZipArchive();
        $result = $zip->open(storage_path('app/public/informes.zip'));
        $this->assertTrue($result === true);
        $this->assertNotFalse($zip->locateName('informe_usuarios.xlsx'));
        $zip->close();
    }
}

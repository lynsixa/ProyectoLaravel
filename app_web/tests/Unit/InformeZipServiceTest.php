<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\InformeZipService;
use App\Services\InformeAdminService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Http\Response as HttpResponse;
use Mockery;
use ZipArchive;

class InformeZipServiceTest extends TestCase
{
    public function test_genera_zip_con_informes()
    {
        // Simulamos Storage
        Storage::fake('public');

        // Creamos un archivo falso de Excel simulado
        $excelPath = storage_path('app/public/informe_usuarios.xlsx');
        file_put_contents($excelPath, 'Contenido de prueba');

        // Mock de InformeAdminService
        $adminServiceMock = Mockery::mock(InformeAdminService::class);
        $adminServiceMock->shouldReceive('generarExcel')->once()->andReturnNull();

        // Instancia del servicio con el mock
        $zipService = new InformeZipService($adminServiceMock);

        // Ejecutamos el método
        $response = $zipService->generarZipConInformes();

        // Verificamos que es una respuesta de descarga
       $this->assertInstanceOf(BinaryFileResponse::class, $response);
        $this->assertTrue(file_exists(storage_path('app/public/informes.zip')));

        // Extra: validar contenido del ZIP
        $zip = new ZipArchive();
        $zip->open(storage_path('app/public/informes.zip'));
        $this->assertEquals(1, $zip->numFiles);
        $this->assertEquals('informe_usuarios.xlsx', $zip->getNameIndex(0));
        $zip->close();

        // Limpieza
        unlink($excelPath);
        unlink(storage_path('app/public/informes.zip'));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}

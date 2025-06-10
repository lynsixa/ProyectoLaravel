<?php

namespace App\Services;

use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

/**
 * Servicio que empaqueta múltiples informes en un archivo ZIP.
 */
class InformeZipService
{
    protected InformeAdminService $AdminService;

    public function __construct(
        InformeAdminService $AdminService,
    ) {
        $this->AdminService = $AdminService;
    }

    /**
     * Genera un archivo ZIP con los informes de usuarios y órdenes.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function generarZipConInformes()
    {
        // Generar informes individuales
        $AdminPath = storage_path('app/public/informe_usuarios.xlsx');

        $this->AdminService->generarExcel(); // Crea informe_usuarios.xlsx

        $zipPath = storage_path('app/public/informes.zip');
        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            $zip->addFile($AdminPath, 'informe_usuarios.xlsx');
            $zip->close();
        }

        return Response::download($zipPath)->deleteFileAfterSend(true);
    }
}

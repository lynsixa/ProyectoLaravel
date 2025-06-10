<?php

namespace App\Services\Informes;

use App\Interfaces\Informes\InformeZipGerenteServiceInterface;
use App\Interfaces\Informes\InformeUsuarioGerenteServiceInterface;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class InformeZipGerenteService
 *
 * Servicio encargado de generar un archivo ZIP que contiene informes (por ejemplo, Excel de usuarios).
 * Este servicio sigue el principio de responsabilidad única al encargarse únicamente de empaquetar archivos.
 * Se apoya en el servicio InformeUsuarioGerenteServiceInterface para generar el contenido.
 *
 * @package App\Services\Informes
 */
class InformeZipGerenteService implements InformeZipGerenteServiceInterface
{
    /**
     * Servicio de generación de informe Excel de usuarios.
     *
     * @var InformeUsuarioGerenteServiceInterface
     */
    protected InformeUsuarioGerenteServiceInterface $usuarioService;

    /**
     * Constructor del servicio.
     *
     * @param InformeUsuarioGerenteServiceInterface $usuarioService Servicio responsable de generar el Excel de usuarios.
     */
    public function __construct(InformeUsuarioGerenteServiceInterface $usuarioService)
    {
        $this->usuarioService = $usuarioService;
    }

    /**
     * Genera un archivo ZIP que contiene el informe de usuarios en Excel.
     *
     * @return BinaryFileResponse Respuesta HTTP con el archivo ZIP para descarga.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException Si el archivo ZIP no puede ser creado.
     */
    public function generarZip(): BinaryFileResponse
    {
        // Generar primero el Excel usando el servicio correspondiente
        $excelResponse = $this->usuarioService->generarExcel();

        $excelPath = storage_path('app/public/informe_usuarios.xlsx');
        $zipPath = storage_path('app/public/informes.zip');

        // Crear el archivo ZIP e incluir el Excel generado
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
            $zip->addFile($excelPath, 'informe_usuarios.xlsx');
            $zip->close();
        } else {
            abort(500, 'No se pudo crear el archivo ZIP.');
        }

        // Retornar el ZIP como descarga
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}

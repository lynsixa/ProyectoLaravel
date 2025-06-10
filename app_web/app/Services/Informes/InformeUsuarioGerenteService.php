<?php

namespace App\Services\Informes;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Interfaces\Informes\InformeUsuarioGerenteServiceInterface;
use App\Models\Usuario;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Facades\Storage;

/**
 * Class InformeUsuarioGerenteService
 *
 * Servicio encargado de generar un informe Excel de los usuarios del sistema,
 * incluyendo su información personal, rol y tipo de documento.
 * Aplica el principio SRP al encargarse únicamente de la generación del archivo Excel.
 *
 * @package App\Services\Informes
 */
class InformeUsuarioGerenteService implements InformeUsuarioGerenteServiceInterface
{
    /**
     * Genera un archivo Excel con información detallada de los usuarios y lo retorna como descarga.
     *
     * @return BinaryFileResponse Respuesta HTTP con el archivo Excel para descarga
     */
    public function generarExcel(): BinaryFileResponse
    {
        $usuarios = Usuario::with('tipoDeDocumento', 'roles')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Usuarios');

        // Cabecera del archivo
        $sheet->fromArray(
            ['Nombres', 'Apellidos', 'Documento', 'Correo', 'Rol', 'Tipo Documento'],
            null,
            'A1'
        );

        // Inserción de datos en el Excel
        $row = 2;
        foreach ($usuarios as $usuario) {
            $sheet->setCellValue("A$row", $usuario->Nombres);
            $sheet->setCellValue("B$row", $usuario->Apellidos);
            $sheet->setCellValue("C$row", $usuario->Documento);
            $sheet->setCellValue("D$row", $usuario->Correo);
            $sheet->setCellValue("E$row", optional($usuario->roles)->Descripcion);
            $sheet->setCellValue("F$row", optional($usuario->tipoDeDocumento)->Descripcion);
            $row++;
        }

        // Guardar y preparar la respuesta con el archivo Excel
        $fileName = 'informe_usuarios.xlsx';
        $filePath = storage_path("app/public/{$fileName}");

        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}

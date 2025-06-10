<?php

namespace App\Services;

use App\Models\Usuario;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

/**
 * Servicio responsable de generar el informe de administradores en Excel.
 */
class InformeAdminService
{
    /**
     * Genera los datos del archivo Excel como un objeto Spreadsheet.
     *
     * @return Spreadsheet
     */
    public function generarDatosExcel(): Spreadsheet
    {
        $usuarios = Usuario::with('tipoDeDocumento', 'roles')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle('Usuarios');

        $sheet->fromArray([
            ['Nombres', 'Apellidos', 'Documento', 'Correo', 'Rol', 'Tipo Documento']
        ], null, 'A1');

        $row = 2;
        foreach ($usuarios as $usuario) {
            $sheet->fromArray([
                $usuario->Nombres,
                $usuario->Apellidos,
                $usuario->Documento,
                $usuario->Correo,
                $usuario->roles->Descripcion,
                $usuario->tipoDeDocumento->Descripcion
            ], null, "A$row");
            $row++;
        }

        return $spreadsheet;
    }

    /**
     * Genera el archivo Excel de usuarios y lo retorna como respuesta de descarga.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function generarExcel()
    {
        $spreadsheet = $this->generarDatosExcel();

        $filename = 'informe_usuarios.xlsx';
        $path = storage_path("app/public/$filename");

        (new Xlsx($spreadsheet))->save($path);

        return Response::download($path)->deleteFileAfterSend(true);
    }
}

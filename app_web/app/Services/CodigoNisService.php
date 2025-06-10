<?php

namespace App\Services;

use App\Interfaces\CodigoNisServiceInterface;
use Illuminate\Http\Request;
use App\Models\CodigoNis;
use Illuminate\Support\Facades\Session;

/**
 * Servicio para manejar la lógica de negocio relacionada con códigos NIS.
 */
class CodigoNisService implements CodigoNisServiceInterface
{
    /**
     * Valida un código NIS y almacena los datos en la sesión.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function validar(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
        ]);

        $codigoIngresado = $request->codigo;
        $codigo = CodigoNis::where('Descripcion', $codigoIngresado)->first();

        if (!$codigo) {
            return back()->with('mensaje', 'Código no existe');
        }

        if ($codigo->Disponibilidad == 0) {
            return back()->with('mensaje', 'Código ya utilizado, no puede ingresar');
        }

        // Marcar código como usado
        $codigo->Disponibilidad = 0;
        $codigo->save();

        // Guardar en sesión
        Session::put('codigo', $codigoIngresado);
        Session::put('numeroMesa', $codigo->Mesa_idMesa);
        Session::put('numeroPiso', $codigo->Eventos_idEventos ?? 'No disponible');

        // Aquí puede integrarse una lógica real para obtener el menú
        $menuDescripcion = "Menú ejemplo";
        Session::put('menuDescripcion', $menuDescripcion);

        return redirect()->route('usuarios.codigonis.indexscan');
    }

    /**
     * Elimina los datos de sesión y redirige al login.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cerrarSesion()
    {
        Session::flush();
        return redirect()->route('login');
    }
}

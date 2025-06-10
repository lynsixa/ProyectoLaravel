<?php

namespace App\Http\Controllers;

use App\Interfaces\NISServiceInterface;
use Illuminate\Http\Request;

/**
 * Controlador para la gestión de códigos NIS.
 *
 * @category Controlador
 * @package App\Http\Controllers
 */
class NISController extends Controller
{
    protected NISServiceInterface $nisService;

    public function __construct(NISServiceInterface $nisService)
    {
        $this->nisService = $nisService;
    }

    /**
     * Mostrar la lista de NIS.
     */
    public function index()
    {
        $nis = $this->nisService->obtenerTodos();
        return view('admin.nis.index', compact('nis'));
    }

    /**
     * Mostrar formulario de creación de NIS.
     */
    public function create()
    {
        $datos = $this->nisService->obtenerRecursosFormulario();
        return view('admin.nis.create', $datos);
    }

    /**
     * Almacenar un nuevo NIS.
     */
    public function store(Request $request)
    {
        try {
            $this->nisService->crear($request);
            return redirect()->route('admin.nis.index')->with('success', 'NIS creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Mostrar formulario de edición de NIS.
     */
    public function edit($id)
    {
        $nis = $this->nisService->obtenerPorId($id);
        $datos = $this->nisService->obtenerRecursosFormulario();
        return view('admin.nis.edit', array_merge(['nis' => $nis], $datos));
    }

    /**
     * Actualizar un NIS existente.
     */
    public function update(Request $request, $id)
    {
        try {
            $this->nisService->actualizar($id, $request);
            return redirect()->route('admin.nis.index')->with('success', 'NIS actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Eliminar un NIS.
     */
    public function destroy($id)
    {
        $this->nisService->eliminar($id);
        return redirect()->route('admin.nis.index')->with('success', 'NIS eliminado exitosamente');
    }
}

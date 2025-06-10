<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\MesaServiceInterface;

/**
 * Class MesaController
 *
 * Controlador responsable de gestionar las operaciones CRUD para el modelo Mesa.
 * Aplica el principio de inversión de dependencias al utilizar MesaServiceInterface.
 *
 * @package App\Http\Controllers
 */
class MesaController extends Controller
{
    /**
     * Servicio de mesas para la lógica de negocio.
     *
     * @var MesaServiceInterface
     */
    protected MesaServiceInterface $mesaService;

    /**
     * Constructor del controlador.
     *
     * @param MesaServiceInterface $mesaService
     */
    public function __construct(MesaServiceInterface $mesaService)
    {
        $this->mesaService = $mesaService;
    }

    /**
     * Muestra una lista de todas las mesas.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $mesas = $this->mesaService->obtenerTodas();
        return view('admin.mesas.index', compact('mesas'));
    }

    /**
     * Almacena una nueva mesa en la base de datos.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'NumeroPiso' => 'required|integer',
            'NumeroMesa' => 'required|integer',
        ]);

        $this->mesaService->crear($request->only(['NumeroPiso', 'NumeroMesa']));

        return redirect()->route('admin.mesas.index')->with('success', 'Mesa creada con éxito.');
    }

    /**
     * Muestra el formulario de edición para una mesa específica.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $mesa = $this->mesaService->obtenerPorId($id);
        return view('admin.mesas.edit', compact('mesa'));
    }

    /**
     * Actualiza la información de una mesa específica.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'NumeroPiso' => 'required|integer',
            'NumeroMesa' => 'required|integer',
        ]);

        $this->mesaService->actualizar($id, $request->only(['NumeroPiso', 'NumeroMesa']));

        return redirect()->route('admin.mesas.index')->with('success', 'Mesa actualizada con éxito.');
    }

    /**
     * Elimina una mesa específica de la base de datos.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->mesaService->eliminar($id);

        return redirect()->route('admin.mesas.index')->with('success', 'Mesa eliminada con éxito.');
    }
}

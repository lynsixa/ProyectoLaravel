<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\EventoServiceInterface;

/**
 * Class EventoController
 *
 * Controlador encargado de manejar la lógica relacionada con la gestión de eventos
 * en el panel administrativo. Se comunica con el servicio de eventos a través de una interfaz.
 *
 * @package App\Http\Controllers
 */
class EventoController extends Controller
{
    /**
     * Servicio que maneja la lógica de negocio relacionada con eventos.
     *
     * @var EventoServiceInterface
     */
    protected EventoServiceInterface $eventoService;

    /**
     * Constructor que inyecta el servicio de eventos.
     *
     * @param EventoServiceInterface $eventoService
     */
    public function __construct(EventoServiceInterface $eventoService)
    {
        $this->eventoService = $eventoService;
    }

    /**
     * Muestra la lista de eventos ordenados por fecha.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $eventos = $this->eventoService->obtenerTodos();
        return view('admin.eventos.index', compact('eventos'));
    }

    /**
     * Almacena un nuevo evento en la base de datos.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_evento' => 'required|date',
        ]);

        $this->eventoService->crear($request->only(['titulo', 'descripcion', 'fecha_evento']));

        return redirect()->route('admin.eventos.index')->with('success', 'Evento agregado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un evento específico.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $evento = $this->eventoService->obtenerPorId($id);
        return view('admin.eventos.edit', compact('evento'));
    }

    /**
     * Actualiza la información de un evento existente.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_evento' => 'required|date',
        ]);

        $this->eventoService->actualizar($id, $request->only(['titulo', 'descripcion', 'fecha_evento']));

        return redirect()->route('admin.eventos.index')->with('success', 'Evento actualizado correctamente.');
    }

    /**
     * Elimina un evento de la base de datos.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $this->eventoService->eliminar($id);

        return redirect()->route('admin.eventos.index')->with('success', 'Evento eliminado exitosamente.');
    }
}

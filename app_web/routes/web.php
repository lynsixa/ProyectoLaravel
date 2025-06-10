<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RecuperarController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\NISController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AdminInformeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\GerenteController;
use App\Http\Controllers\GerenteInformeControllerV2;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\MeseroController;
use App\Http\Controllers\Usuarios\CodigoNisController;
use App\Http\Controllers\MenuController; 
use App\Http\Controllers\OrdenController;   

// Rutas de inicio, registro y login
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/registro', [RegistroController::class, 'showForm'])->name('registro.form');
Route::post('/registro', [RegistroController::class, 'registrar'])->name('registro.enviar');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas para recuperar contraseña
Route::get('/recuperar', [RecuperarController::class, 'showForm'])->name('recuperar.form');
Route::post('/recuperar', [RecuperarController::class, 'enviarCorreo'])->name('recuperar.enviar');
Route::get('/recuperar/cambiar/{id}/{token}', [RecuperarController::class, 'cambiarForm'])->name('recuperar.cambiar.form');
Route::post('/recuperar/cambiar', [RecuperarController::class, 'cambiarPassword'])->name('recuperar.cambiar.enviar');

// DASHBOARD POR ROLES
Route::get('/admin', function () {
    return view('admin.index');
})->name('admin.index');

// RUTAS DE ADMIN
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');
    Route::post('/eventos', [EventoController::class, 'store'])->name('eventos.store');
    Route::get('/eventos/{evento}/edit', [EventoController::class, 'edit'])->name('eventos.edit');
    Route::put('/eventos/{evento}', [EventoController::class, 'update'])->name('eventos.update');
    Route::delete('/eventos/{evento}', [EventoController::class, 'destroy'])->name('eventos.destroy');

    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');
    Route::get('/calendario/eventos', [CalendarioController::class, 'eventos'])->name('calendario.eventos');

    Route::get('/nis', [NISController::class, 'index'])->name('nis.index');
    Route::get('/nis/create', [NISController::class, 'create'])->name('nis.create');
    Route::post('/nis', [NISController::class, 'store'])->name('nis.store');
    Route::get('/nis/{nis}/edit', [NISController::class, 'edit'])->name('nis.edit');
    Route::put('/nis/{nis}', [NISController::class, 'update'])->name('nis.update');
    Route::delete('/nis/{nis}', [NISController::class, 'destroy'])->name('nis.destroy');

    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuario.index');
    Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuario.create');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuario.store');
    Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuario.edit');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuario.update');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuario.destroy');

    // INFORMES ADMIN (usa el AdminInformeController con servicios)
    Route::get('/informes', [AdminInformeController::class, 'index'])->name('informes.index');
    Route::get('/informes/usuarios', [AdminInformeController::class, 'generarInformeUsuarios'])->name('informes.usuarios');
    Route::get('/informes/todos', [AdminInformeController::class, 'generarTodosLosInformes'])->name('informes.todos');

    // PRODUCTOS
    Route::get('/productos', [ProductoController::class, 'index'])->name('producto.index');
    Route::get('/producto/create', [ProductoController::class, 'create'])->name('producto.create');
    Route::post('/producto', [ProductoController::class, 'store'])->name('producto.store');
    Route::get('/producto/{id}/edit', [ProductoController::class, 'edit'])->name('producto.edit');
    Route::put('/producto/{id}', [ProductoController::class, 'update'])->name('producto.update');
    Route::delete('/producto/{id}', [ProductoController::class, 'destroy'])->name('producto.destroy');
});

// RUTAS DE GERENTE
Route::prefix('gerente')->name('gerente.')->group(function () {
    Route::get('/', [GerenteController::class, 'index'])->name('index');

    Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');
    Route::post('/eventos', [EventoController::class, 'store'])->name('eventos.store');
    Route::get('/eventos/{evento}/edit', [EventoController::class, 'edit'])->name('eventos.edit');
    Route::put('/eventos/{evento}', [EventoController::class, 'update'])->name('eventos.update');
    Route::delete('/eventos/{evento}', [EventoController::class, 'destroy'])->name('eventos.destroy');

    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario.index');
    Route::get('/calendario/eventos', [CalendarioController::class, 'eventos'])->name('calendario.eventos');

    Route::get('/nis', [NISController::class, 'index'])->name('nis.index');
    Route::get('/nis/create', [NISController::class, 'create'])->name('nis.create');
    Route::post('/nis', [NISController::class, 'store'])->name('nis.store');
    Route::get('/nis/{nis}/edit', [NISController::class, 'edit'])->name('nis.edit');
    Route::put('/nis/{nis}', [NISController::class, 'update'])->name('nis.update');
    Route::delete('/nis/{nis}', [NISController::class, 'destroy'])->name('nis.destroy');

    Route::get('/informes', [GerenteInformeControllerV2::class, 'index'])->name('informes.index');
    Route::get('/informes/usuarios', [GerenteInformeControllerV2::class, 'generarInformeUsuarios'])->name('informes.usuarios');
    Route::get('/informes/ordenes', [GerenteInformeControllerV2::class, 'generarInformeOrdenes'])->name('informes.ordenes');
    Route::get('/informes/todos', [GerenteInformeControllerV2::class, 'generarTodosLosInformes'])->name('informes.todos');

    Route::get('/productos', [ProductoController::class, 'index'])->name('producto.index');
    Route::get('/producto/create', [ProductoController::class, 'create'])->name('producto.create');
    Route::post('/producto', [ProductoController::class, 'store'])->name('producto.store');
    Route::get('/producto/{id}/edit', [ProductoController::class, 'edit'])->name('producto.edit');
    Route::put('/producto/{id}', [ProductoController::class, 'update'])->name('producto.update');
    Route::delete('/producto/{id}', [ProductoController::class, 'destroy'])->name('producto.destroy');
});

// Rutas de bartender
Route::prefix('bartender')->name('bartender.')->group(function () {
    Route::get('/', [SolicitudController::class, 'index'])->name('index');
    Route::post('/despachar', [SolicitudController::class, 'despachar'])->name('despachar');
    Route::post('/rechazar', [SolicitudController::class, 'rechazar'])->name('rechazar');
});

// Rutas de mesero
Route::prefix('mesero')->name('mesero.')->group(function () {
    Route::get('/', [MeseroController::class, 'index'])->name('index');
    Route::post('/entregar', [MeseroController::class, 'entregar'])->name('entregar');
    Route::post('/rechazar', [MeseroController::class, 'rechazar'])->name('rechazar');
});

// Rutas de ingreso de código NIS
Route::prefix('usuarios/codigonis')->name('usuarios.codigonis.')->group(function () {
    Route::get('/', [CodigoNisController::class, 'index'])->name('index');
    Route::post('/', [CodigoNisController::class, 'validarCodigo'])->name('validar');
    Route::get('/indexscan', [CodigoNisController::class, 'indexScan'])->name('indexscan');
    Route::get('/cerrar-sesion', [CodigoNisController::class, 'cerrarSesion'])->name('cerrar_sesion');
});

Route::controller(MenuController::class)->prefix('menu')->name('menu.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/agregar', 'agregarAlCarrito')->name('agregar');
    Route::delete('/eliminar/{productoId}', 'eliminarDelCarrito')->name('eliminar');
    Route::delete('/vaciar', 'vaciarCarrito')->name('vaciar');
});

Route::post('/orden/guardar-desde-carrito', [OrdenController::class, 'guardarDesdeCarrito'])->name('orden.guardarDesdeCarrito');


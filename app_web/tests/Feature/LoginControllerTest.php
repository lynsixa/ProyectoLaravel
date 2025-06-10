<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\Rol;
use App\Models\TipoDeDocumento;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Definir rutas dummy necesarias para las redirecciones
        Route::get('/admin', fn () => 'Admin')->name('admin.index');
        Route::get('/login', fn () => 'Login View')->name('login');
    }

    public function test_muestra_formulario_login()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertSee('Login View'); // o assertViewIs si usas vistas reales
    }

    public function test_login_exitoso_redirige_a_vista_según_rol()
{
    // Asegura las claves foráneas
    TipoDeDocumento::create([
        'idTipodedocumento' => 1,
        'Descripcion' => 'Cédula',
    ]);

    Rol::create([
        'idRoles' => 1,
        'Descripcion' => 'Admin',
    ]);

    $usuario = Usuario::factory()->create([
        'Correo' => 'admin@example.com',
        'Contraseña' => bcrypt('adminpass'),
        'Roles_idRoles' => 1,
        'Tipo_de_documento_idTipodedocumento' => 1,
    ]);

    $response = $this->post(route('login.process'), [
        'correo' => 'admin@example.com',
        'password' => 'adminpass',
    ]);

    $response->assertRedirect(route('admin.index'));
    $this->assertEquals(session('idUsuario'), $usuario->idUsuario);
    $this->assertEquals(session('rol'), 1);
}

    public function test_login_falla_con_credenciales_invalidas()
    {
        $response = $this->from(route('login'))->post(route('login.process'), [
            'correo' => 'invalid@example.com',
            'password' => 'wrongpass',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('correo');
    }

    public function test_logout_elimina_sesion_y_redirige()
    {
        session(['idUsuario' => 123, 'rol' => 1]);

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertFalse(session()->has('idUsuario'));
        $this->assertFalse(session()->has('rol'));
    }
}

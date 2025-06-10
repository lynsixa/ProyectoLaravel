<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\AuthServiceInterface;
use App\Services\AuthService;
use App\Interfaces\RegistroServiceInterface;
use App\Services\RegistroService;
use App\Interfaces\PasswordResetServiceInterface;
use App\Services\PasswordResetService;
use App\Interfaces\CodigoNisServiceInterface;
use App\Services\CodigoNisService;
use App\Interfaces\CalendarioServiceInterface;
use App\Services\CalendarioService;
use App\Interfaces\MesaServiceInterface;
use App\Services\MesaService;
use App\Interfaces\NISServiceInterface;
use App\Services\NISService;
use App\Interfaces\EntregaServiceInterface;
use App\Services\EntregaService;
use App\Interfaces\SolicitudServiceInterface;
use App\Services\SolicitudService;
use App\Interfaces\UsuarioServiceInterface;
use App\Services\UsuarioService;
use App\Interfaces\RolServiceInterface;
use App\Services\RolService;
use App\Interfaces\ProductoMenuServiceInterface;
use App\Services\ProductoMenuService;
use App\Interfaces\OrdenServiceInterface;
use App\Services\OrdenService;
use App\Interfaces\ProductoServiceInterface;
use App\Services\ProductoService;
use App\Services\EventoService;
use App\Interfaces\EventoServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(PasswordResetServiceInterface::class, PasswordResetService::class);
        $this->app->bind(CodigoNisServiceInterface::class, CodigoNisService::class);
        $this->app->bind(CalendarioServiceInterface::class, CalendarioService::class);
        $this->app->bind(MesaServiceInterface::class, MesaService::class);
        $this->app->bind(NISServiceInterface::class, NISService::class);
        $this->app->bind(EntregaServiceInterface::class, EntregaService::class);
        $this->app->bind(SolicitudServiceInterface::class, SolicitudService::class);
        $this->app->bind(UsuarioServiceInterface::class, UsuarioService::class);
        $this->app->bind(RolServiceInterface::class, RolService::class);
        $this->app->bind(ProductoMenuServiceInterface::class, ProductoMenuService::class);
        $this->app->bind(OrdenServiceInterface::class, OrdenService::class);
        $this->app->bind(ProductoServiceInterface::class, ProductoService::class);
        $this->app->bind(EventoServiceInterface::class, EventoService::class);
        $this->app->bind(RegistroServiceInterface::class, RegistroService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmendsrtvTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabla tipo_de_documento
        Schema::create('tipo_de_documento', function (Blueprint $table) {
            $table->id('idTipodedocumento');
            $table->string('Descripcion', 45);
        });

        // Tabla roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id('idRoles');
            $table->string('Descripcion', 45);
        });

        // Tabla usuario
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('idUsuario');
            $table->string('Nombres', 45);
            $table->string('Apellidos', 45);
            $table->string('Documento', 35);
            $table->string('Correo', 100);
            $table->binary('Contraseña');
            $table->date('FechaDeNacimiento');
            $table->string('token', 40);
            $table->string('token_password', 100)->nullable();
            $table->integer('password_request')->default(0);
            $table->unsignedBigInteger('Tipo_de_documento_idTipodedocumento')->nullable();
            $table->unsignedBigInteger('Roles_idRoles');
            $table->unsignedBigInteger('CodigoNis_idCodigoNis')->nullable();

            $table->foreign('Tipo_de_documento_idTipodedocumento')->references('idTipodedocumento')->on('tipo_de_documento');
            $table->foreign('Roles_idRoles')->references('idRoles')->on('roles');
        });

        // Tabla menu
        Schema::create('menu', function (Blueprint $table) {
            $table->id('idMenu');
            $table->string('Descripcion', 400);
        });

        // Tabla mesa
        Schema::create('mesa', function (Blueprint $table) {
            $table->id('idMesa');
            $table->integer('NumeroPiso');
            $table->integer('NumeroMesa');
        });

        // Tabla eventos
        Schema::create('eventos', function (Blueprint $table) {
            $table->increments('idEventos');
            $table->string('Titulo', 255);
            $table->string('Descripcion', 50);
            $table->dateTime('Fecha_Evento');
        });

        // Tabla codigonis
        Schema::create('codigonis', function (Blueprint $table) {
            $table->id('idCodigoNis');
            $table->string('Descripcion', 100);
            $table->tinyInteger('Disponibilidad');
            $table->unsignedBigInteger('Menu_idMenu');
            $table->unsignedBigInteger('Mesa_idMesa');
            $table->unsignedBigInteger('Eventos_idEventos')->nullable();

            $table->foreign('Menu_idMenu')->references('idMenu')->on('menu');
            $table->foreign('Mesa_idMesa')->references('idMesa')->on('mesa');
            $table->foreign('Eventos_idEventos')->references('idEventos')->on('eventos');
        });

        // Tabla entrega
        Schema::create('entrega', function (Blueprint $table) {
            $table->id('idEntrega');
            $table->string('Descripcion', 450)->nullable();
            $table->tinyInteger('Entregado');
        });

        // Tabla solicitud
        Schema::create('solicitud', function (Blueprint $table) {
            $table->id('idSolicitud');
            $table->string('Descripcion', 405);
            $table->string('Informe', 450)->nullable();
            $table->tinyInteger('Despachado');
            $table->unsignedBigInteger('Entrega_idEntrega')->nullable();

            $table->foreign('Entrega_idEntrega')->references('idEntrega')->on('entrega');
        });

        // Tabla producto
        Schema::create('producto', function (Blueprint $table) {
            $table->id('idProducto');
            $table->decimal('Precio', 10, 3);
            $table->tinyInteger('Disponibilidad');
            $table->integer('Cantidad');
            $table->unsignedBigInteger('CodigoNis_idCodigoNis')->nullable();
            $table->unsignedBigInteger('Categoria_idCategoria')->nullable();

            $table->foreign('CodigoNis_idCodigoNis')->references('idCodigoNis')->on('codigonis');
        });

        // Tabla categoria
        Schema::create('categoria', function (Blueprint $table) {
            $table->id('idCategoria');
            $table->string('Nombre', 105);
            $table->string('Descripcion', 450);
            $table->string('Foto1', 350);
            $table->string('Foto2', 350)->nullable();
            $table->string('Foto3', 350)->nullable();
            $table->unsignedBigInteger('Producto_idProducto');

            $table->foreign('Producto_idProducto')->references('idProducto')->on('producto');
        });

        // Tabla orden
        Schema::create('orden', function (Blueprint $table) {
            $table->id('idOrden');
            $table->string('TokenCliente', 450)->nullable();
            $table->string('Descripcion', 450);
            $table->float('PrecioFinal');
            $table->dateTime('Fecha');
            $table->unsignedBigInteger('Producto_idProducto')->nullable();
            $table->unsignedBigInteger('Solicitud_idSolicitud')->nullable();
            $table->integer('cantidad')->default(1);
            $table->unsignedBigInteger('Usuario_idUsuario')->nullable();

            $table->foreign('Producto_idProducto')->references('idProducto')->on('producto');
            $table->foreign('Solicitud_idSolicitud')->references('idSolicitud')->on('solicitud');
            $table->foreign('Usuario_idUsuario')->references('idUsuario')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden');
        Schema::dropIfExists('categoria');
        Schema::dropIfExists('producto');
        Schema::dropIfExists('solicitud');
        Schema::dropIfExists('entrega');
        Schema::dropIfExists('codigonis');
        Schema::dropIfExists('eventos');
        Schema::dropIfExists('mesa');
        Schema::dropIfExists('menu');
        Schema::dropIfExists('usuario');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('tipo_de_documento');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToMesaTable extends Migration
{
    /**
     * Ejecuta la migración.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mesa', function (Blueprint $table) {
            $table->timestamps(); // Agrega los campos created_at y updated_at
        });
    }

    /**
     * Revierte la migración.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mesa', function (Blueprint $table) {
            $table->dropTimestamps(); // Elimina los campos created_at y updated_at
        });
    }
}

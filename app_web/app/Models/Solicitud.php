<?php
// app/Models/Solicitud.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitud';  // Definir la tabla de la base de datos
    protected $primaryKey = 'idSolicitud';
    public $timestamps = false;
    protected $fillable = ['Descripcion', 'Informe', 'Despachado', 'Entrega_idEntrega'];  // Campos que pueden ser asignados masivamente

    // Relación con la tabla 'entrega'
    public function entregas()
    {
        // Definir la relación con la tabla 'entrega' usando el campo 'Entrega_idEntrega' como clave foránea
        return $this->hasMany(Entrega::class, 'Entrega_idEntrega', 'idSolicitud');
    }
}

<?php

// app/Models/CodigoNis.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class CodigoNis extends Model
{
    use HasFactory;
    
    protected $table = 'codigonis';

    protected $primaryKey = 'idCodigoNis';

    public $timestamps = true;

    protected $fillable = [
        'Descripcion',
        'Disponibilidad',
        'Menu_idMenu',
        'Mesa_idMesa',
        'Eventos_idEventos',
    ];
}

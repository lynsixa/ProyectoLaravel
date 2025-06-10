<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Orden extends Model
{
    use HasFactory;
    
    protected $table = 'orden';
    protected $primaryKey = 'idOrden';
    public $timestamps = false;

    protected $fillable = [
        'TokenCliente',
        'Descripcion',
        'PrecioFinal',
        'Fecha',
        'Producto_idProducto',
        'Solicitud_idSolicitud',
        'cantidad',
        'Usuario_idUsuario',
    ];

    // Relaciones
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'Producto_idProducto');
    }

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'Solicitud_idSolicitud');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'Usuario_idUsuario');
    }
}

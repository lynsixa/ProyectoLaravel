<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    use HasFactory;

    protected $table = 'entrega';  // Nombre de la tabla en la base de datos
    protected $primaryKey = 'idEntrega';  // Definir la clave primaria como 'idEntrega'
    public $timestamps = false;  // Desactivar el uso de timestamps si no los necesitas

    protected $fillable = ['Descripcion', 'Informe', 'Entregado', 'Entrega_idEntrega'];
    
    // Relación con la tabla `solicitud`
    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'Entrega_idEntrega', 'idSolicitud');
    }
}
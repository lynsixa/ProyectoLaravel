<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TipoDeDocumento extends Model
{
    use HasFactory;
    
    protected $table = 'tipo_de_documento'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'idTipodedocumento'; // Clave primaria
    public $timestamps = false; // No usamos created_at y updated_at

      protected $fillable = [
        'idTipodedocumento', // 👈 agrega esto
        'Descripcion',
    ];
}
